<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BkashController;
use App\Http\Controllers\PaymentController;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Member;
use Carbon\Carbon;

class MemberOnlinePayController extends Controller {
    protected $bkash;
    protected $paymentcontroller;

    public function __construct(BkashController $bkash, PaymentController $paymentcontroller)
    {
        $this->bkash = $bkash;
        $this->paymentcontroller = $paymentcontroller;
    }
    // Create a payment

    public function createPayment( Request $request ) {

        $request->validate( [
            'package_id' => 'required|exists:packages,id|max:255',
        ] );

        $package = Package::findOrFail( $request->package_id );

        $amount_paid = 0;

        if ( $package->price > 0 ) {
            $amount_paid = $package->price - ( $package->discount ?? 0 );
        }
        if ( $package->price < 1 ) {
            $amount_paid = $request->paid;
        }
        if ( $amount_paid < 1 ) {
            return $this->flash_and_back( 'danger', 'Payment amount wrong' );
        }

        $member = Member::where( 'phone_number', get_user_id() )->first();
        if ( !$member ) {
            abort( 404 );
        };

        $target_member_max_validity_row = Payment::where( 'member_id', $member->id )
        ->whereNotNull( 'validity' )
        ->where( 'validity', '!=', '' )
        ->where( 'status', 'Success' )
        ->orderByDesc( 'validity' )
        ->first();

        $member_current_validity = $target_member_max_validity_row ? $target_member_max_validity_row->validity : null;

        $payment_validity = null;

        if ( $package->duration > 0 ) {
            if ( $member_current_validity ) {
                $payment_validity = Carbon::parse( $member_current_validity )->addDays( $package->duration )->toDateString();
            } else {
                $payment_validity = Carbon::today()->addDays( $package->duration )->toDateString();
            }
        } else {
            $payment_validity = null;
        }

        $payment = new Payment;
        $payment->member_id = $member->id;
        $payment->package_id = $request->package_id;
        $payment->package_name = $package->name;
        $payment->package_price = $package->price;
        $payment->package_duration = $package->duration;
        $payment->discount = $package->discount;
        $payment->paid = $amount_paid;
        $payment->due = 0;
        $payment->pay_by = 'Online';
        $payment->date = Carbon::today()->toDateString();
        $payment->validity = $payment_validity;
        $payment->comments = $request->comments;
        $payment->status = 'Fail';
        $payment->save();

        // dd( $payment );

        $request->replace([]); 
        $request->merge( [
            'amount' => $amount_paid,
            'merchantInvoiceNumber' => $payment->id,
            'payerReference' => 'no',
            'callbackurl' => '/member/bkash/pay/callback',
        ] );

        // dd( $request->all() );

        // Call BkashController to handle payment creation
        return $this->bkash->createPayment( $request );
    }

    // Handle bKash callback

    public function handleCallback( Request $request ) {
        $allRequest = $request->all();

        if ( isset( $allRequest[ 'status' ] ) && $allRequest[ 'status' ] == 'failure' ) {


            // return response(['status' => 'failure', 'allRequest' => $allRequest], 200); 
            // {
            //     "status": "failure",
            //     "allRequest": {
            //     "paymentID": "TR0011rwFL10N1732792855003",
            //     "status": "failure",
            //     "signature": "LaP9lziayz",
            //     "apiVersion": "1.2.0-beta/"
            //     }
            //  } 

            $this->flash_msg('danger', 'Payment fail! (1)'); 
            return redirect('/member_panel/pay/form');

        } else if ( isset( $allRequest[ 'status' ] ) && $allRequest[ 'status' ] == 'cancel' ) {
           
            // return response(['status' => 'cancel', 'allRequest' => $allRequest], 200); 
            // {
            //     "status": "cancel",
            //     "allRequest": {
            //     "paymentID": "TR0011wA1qaU61732793058732",
            //     "status": "cancel",
            //     "signature": "gNsNLxWDBo",
            //     "apiVersion": "1.2.0-beta/"
            //     }
            // } 
           
            $this->flash_msg('danger', 'Payment canceled!'); 
            return redirect('/member_panel/pay/form');

        } else {

            $response = $this->bkash->executePayment( $allRequest[ 'paymentID' ] );

            $res_array = json_decode( $response, true );

            if ( array_key_exists( 'message', $res_array ) ) {
                // if execute api failed to response
                sleep( 1 );
                $response = $this->queryPayment( $allRequest[ 'paymentID' ] );
                $res_array = json_decode( $response, true );            

                return response(['status' => 'api fail', 'response_array' => $res_array], 200);  

                $this->flash_msg('danger', 'Something went wrong!'); 
                return redirect('/member_panel/pay/form');
            }

            if ( array_key_exists( 'statusCode', $res_array ) && $res_array[ 'statusCode' ] == '0000' && array_key_exists( 'transactionStatus', $res_array ) && $res_array[ 'transactionStatus' ] == 'Completed' ) {
                // success
                // return $res_array;

                // payment find 
                $payment = Payment::find($res_array['merchantInvoiceNumber']);
                if(!$payment){
                    $this->flash_msg('danger', 'Payment fail, contact with admin urgent!'); 
                    return redirect('/member_panel/pay/form');
                }
                $payment->status = 'Success';
                $payment->comments = 'Paid by bkash, transaction id ' . $res_array['trxID'] . ' // transaction details: ' . json_encode($res_array);
                $payment->save();

                $this->paymentcontroller->updateMemberStatusAndValidity($payment->member_id);
                
                $this->flash_msg('success', 'Payment success!'); 
                return redirect('/member_panel/payment_history');

            }


        }

        $this->flash_msg('danger', 'Payment fail! (2)'); 
        return redirect('/member_panel/pay/form');

    }

}
