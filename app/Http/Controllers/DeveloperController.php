<?php

namespace App\Http\Controllers;

use App\Models\SmsCounter;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ManagementSiteSettings;


class DeveloperController extends Controller
{
    public function showSmsCountForm(Request $request)
    {
        $smsCount = null;     

        if ($request->has('month')) {
            $request->validate([
                'month' => 'required|date_format:Y-m', 
            ]);

            $month = $request->input('month');

            $startDate = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            $endDate = Carbon::createFromFormat('Y-m', $month)->endOfMonth();

            $smsCount = SmsCounter::whereBetween('date', [$startDate, $endDate])->sum('count');
        }

        return view('developer.sms_alert.monthly_report', [
            'smsCount' => $smsCount,
        ]);
    }
    public function systemSetting(Request $request)
    {     
        $sms_alert_enable = '';
        $online_payment_enable = '';
        $ManagementSiteSettings = ManagementSiteSettings::select('sms_alert_enable','online_payment_enable')->find(1);     

        return view('developer.system_setting', [
            'ManagementSiteSettings' => $ManagementSiteSettings
        ]);
    }


    public function updateSystemSetting(Request $request)
    {
        $request->validate([
            'sms_alert_enable' => 'required|in:true,false', 
            'online_payment_enable' => 'required|in:true,false', 
        ]);
        
    
        $smsAlertEnable = $request->input('sms_alert_enable'); 
        $onlinePaymentEnable = $request->input('online_payment_enable'); 
    
        $settings = ManagementSiteSettings::select('id', 'sms_alert_enable', 'online_payment_enable')->find(1);

        if ($settings) {
            $settings->sms_alert_enable = $smsAlertEnable; 
            $settings->online_payment_enable = $onlinePaymentEnable; 
            $settings->save();    
            return $this->flash_and_back('success', 'SMS alert status updated successfully.');
        }
        
    
        return $this->flash_and_back('danger', 'Settings record not found.');
    }


}
