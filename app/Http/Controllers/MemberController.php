<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Instruction;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

use App\Models\MemberAttendance;
use Carbon\Carbon;
use App\Models\Package;
use App\Models\ManagementSiteSettings;

// in config/app.php
// 'debug' => env( 'APP_DEBUG', false ),

class MemberController extends Controller {

    // HTTP Method: GET
    // URL: /api/members

    // header
    // Accept: application/json

    // request url
    // GET /api/members?full_name = John&status = active&validity_from = 2023-01-01&validity_to = 2023-12-31

    public function index( Request $request ) {
        try {
            $query = Member::query();

            // Add filters based on request parameters
            if ( !empty( $request->full_name ) ) {
                $query->where( 'full_name', 'LIKE', "%{$request->full_name}%" );
            }
          
          

            // Retrieve data
            $members = $query->get();

            // Respond with success
            return response()->json( [
                'success' => true,
                'data' => $members,
                'message' => 'Members retrieved successfully.',
            ], 200 );
        } catch ( \Exception $e ) {
            // Respond with error
            return response()->json( [
                'success' => false,
                'error' => 'An error occurred while fetching members.',
                'details' => config( 'app.debug' ) ? $e->getMessage() : null, // Show detailed error in debug mode
            ], 500 );
        }
    }


    // HTTP Method: POST
    // URL: /api/members

    // header
    // Content-Type: application/json
    // Accept: application/json

    // Request Body ( JSON ):
    // {
    //     'full_name': 'Jane Doe',
    //     'nid': '9876543210',
    //     'address': '456 Another Street',
    //     'email': 'janedoe@example.com'
    // }

    public function store(Request $request)
    {
        try {
            // Get the allowed fields
            $allowedFields = ['full_name', 'nid', 'address', 'email'];

            // Get the request data
            $requestData = $request->all();

            // Find extra fields (those not in allowedFields)
            $extraFields = array_diff_key($requestData, array_flip($allowedFields));

            // If there are extra fields, return an error response
            if (!empty($extraFields)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid fields provided.',
                    'extra_fields' => $extraFields,
                ], 400);
            }

            // Define validation rules
            $validator = Validator::make($request->only($allowedFields), [
                'full_name' => 'nullable|string|max:255',
                'nid' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'email' => 'required|email|max:255|unique:members,email',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => 'Validation failed.',
                ], 422);
            }

            // Retrieve only validated data
            $validatedData = $request->only($allowedFields);

            // Create a new member and assign data manually
            $member = new Member();
            $member->full_name = $validatedData['full_name'] ?? null;
            $member->nid = $validatedData['nid'] ?? null;
            $member->address = $validatedData['address'] ?? null;
            $member->email = $validatedData['email'];
            $member->save();

            // Return success response
            return response()->json([
                'success' => true,
                'data' => $member,
                'message' => 'Member created successfully.',
            ], 201);
        } catch (\Exception $e) {
            // Return general error response
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while creating the member.',
                'details' => config('app.debug') ? $e->getMessage() : null, // Detailed error in debug mode
            ], 500);
        }
    }

    

    // HTTP Method: GET
    // URL: /api/members/ {id}

    public function show( Request $request ) {
        try {
            // Validate the incoming request to ensure 'id' is provided and is an integer
            $validatedData = $request->validate( [
                'id' => 'required|integer',
            ] );

            // Retrieve the member by ID
            $member = Member::find( $validatedData[ 'id' ] );

            // Check if the member exists
            if ( !$member ) {
                return response()->json( [
                    'success' => false,
                    'error' => 'Member not found.',
                    'message' => 'The requested member does not exist.',
                ], 404 );
            }

            // Return the member details
            return response()->json( [
                'success' => true,
                'data' => $member,
                'message' => 'Member retrieved successfully.',
            ], 200 );
        } catch ( \Exception $e ) {
            // Handle unexpected errors
            return response()->json( [
                'success' => false,
                'error' => 'An error occurred while retrieving the member.',
                'details' => config( 'app.debug' ) ? $e->getMessage() : null, // Show details in debug mode
            ], 500 );
        }
    }

    // HTTP Method: PUT or PATCH
    // URL: /api/members/ {id}

    // Request Body ( JSON ):
    // {
    //     'full_name': 'John Doe Updated',
    //     'nid': '1234567890',
    //     'address': '123 Updated Street',
    //     'email': 'updatedemail@example.com'
    // }

    public function update(Request $request, $id)
    {
        try {
            // Get the allowed fields
            $allowedFields = ['full_name', 'nid', 'address', 'email'];
            
            // Get the request data
            $requestData = $request->all();

            // Find extra fields (those not in allowedFields)
            $extraFields = array_diff_key($requestData, array_flip($allowedFields));

            // If there are extra fields, return an error response
            if (!empty($extraFields)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid fields provided.',
                    'extra_fields' => $extraFields,
                ], 400);
            }

            // Define validation rules
            $validator = Validator::make($request->only($allowedFields), [
                'full_name' => 'nullable|string|max:255',
                'nid' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'email' => 'required|email|max:255|unique:members,email,' . $id,
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => 'Validation failed.',
                ], 422);
            }

            // Retrieve only validated data
            $validatedData = $request->only($allowedFields);

            // Find the member by ID
            $member = Member::find($id);

            if (!$member) {
                return response()->json([
                    'success' => false,
                    'message' => 'Member not found.',
                ], 404);
            }

            // Update the member with new data
            $member->full_name = $validatedData['full_name'] ?? $member->full_name;
            $member->nid = $validatedData['nid'] ?? $member->nid;
            $member->address = $validatedData['address'] ?? $member->address;
            $member->email = $validatedData['email'] ?? $member->email;
            $member->save();

            // Return success response
            return response()->json([
                'success' => true,
                'data' => $member,
                'message' => 'Member updated successfully.',
            ], 200);
        } catch (\Exception $e) {
            // Return general error response
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while updating the member.',
                'details' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }



    // Example Request:
    // HTTP Method: DELETE
    // URL: /api/members/ {id}

    public function destroy( $id ) {
        try {
            // Find the member by ID
            $member = Member::find( $id );

            // Check if the member exists
            if ( !$member ) {
                return response()->json( [
                    'success' => false,
                    'message' => 'Member not found.',
                ], 404 );
            }

            // Delete the member
            $member->delete();

            // Return success response
            return response()->json( [
                'success' => true,
                'message' => 'Member deleted successfully.',
            ], 200 );
        } catch ( \Exception $e ) {
            // Return general error response
            return response()->json( [
                'success' => false,
                'error' => 'An error occurred while deleting the member.',
                'details' => config( 'app.debug' ) ? $e->getMessage() : null, // Detailed error in debug mode
            ], 500 );
        }
    }

}



