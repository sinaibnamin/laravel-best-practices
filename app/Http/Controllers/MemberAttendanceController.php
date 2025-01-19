<?php

namespace App\Http\Controllers;

use App\Models\MemberAttendance;
use Illuminate\Http\Request;
use App\Models\Member;
use Carbon\Carbon;

class MemberAttendanceController extends Controller
{
   
    public function daily_track(Request $request)
    {
        // Fetch all members
        $members = Member::select('image', 'validity', 'status', 'id', 'full_name', 'uniq_id', 'phone_number')->whereIn('status', ['Active', 'Expire'])
        ->orderBy('created_at', 'desc')
        ->get();
    
        // Initialize an empty array for attendance records
        $attendanceRecords = [];
    
        // Get the attendance date
        $attendanceDate = $request->filled('attendance_date') ? $request->attendance_date : today();
    
      
        // Retrieve attendance records for the specified date with the related members
        $attendanceData = MemberAttendance::with(['member:id,full_name,uniq_id'])
        ->where('attendance_date', $attendanceDate)
        ->get();
    
    
        // Loop through all members and check their attendance
        foreach ($members as $member) {
            // Check if the member has an attendance record for the specified date
            $attendance = $attendanceData->firstWhere('member_id', $member->id);
            
            // Add member data along with their attendance status
            $attendanceRecords[] = [
                'member' => $member,
                'present' => $attendance ? true : false, 
                'id' => $attendance ? $attendance->id : null, 
                'attendance_date' => $attendance ? $attendance->attendance_date : null, 
                'created_at' => $attendance ? $attendance->created_at : null, 
            ];
        }
    
        $page_mode = 'admin';

        // dd($attendanceRecords);

        // Return the view with data
        return view('admin.pages.member_attendance.daily_track', [
            'member_attendances' => $attendanceRecords,
            'members' => $members,
            'attendance_report_date' => $attendanceDate,
            'page_mode' => $page_mode,
        ]);
    }
    
    
    public function input(Request $request)
    {
        // Check if the environment is 'demo'
        if ($this->app_environment == 'demo') {
            return response()->json([
                'message' => 'Attendance recorded successfully.',
                'action' => $request->action,
                'member_id' => $request->member_id
            ], 201);
        }
    
        // Validate the incoming request data
        $validatedData = $request->validate([
            'member_id' => 'required|exists:members,id', // Ensure member_id exists in the members table
            'attendance_date' => 'required|date',
            'action' => 'required|in:present,absent',
        ]);
    
        // Retrieve the attendance record for the specified member and date
        $attendance = MemberAttendance::where('member_id', $validatedData['member_id'])
            ->where('attendance_date', $validatedData['attendance_date'])
            ->first();
    
        if ($validatedData['action'] === 'present') {
            if ($attendance) {
                return response()->json([
                    'message' => 'Attendance already present.',
                    'action' => $validatedData['action'],
                    'member_id' => $validatedData['member_id']
                ], 201);
            } else {
                // Create a new attendance record if it does not exist
                MemberAttendance::create([
                    'member_id' => $validatedData['member_id'],
                    'attendance_date' => $validatedData['attendance_date'],
                ]);
                return response()->json([
                    'message' => 'Attendance recorded as present.',
                    'action' => $validatedData['action'],
                    'member_id' => $validatedData['member_id']
                ], 201);
            }
        } elseif ($validatedData['action'] === 'absent') {
            if ($attendance) {
                // Delete the attendance record to mark the member as absent
                $attendance->delete();
                return response()->json([
                    'message' => 'Attendance changed to absent.',
                    'action' => $validatedData['action'],
                    'member_id' => $validatedData['member_id']
                ], 201);
            } else {
                return response()->json([
                    'message' => 'Attendance already marked as absent.',
                    'action' => $validatedData['action'],
                    'member_id' => $validatedData['member_id']
                ], 201);
            }
        } else {
            return response()->json(['message' => 'Invalid action specified.'], 400);
        }
    }
    
    

    public function monthly_report(Request $request)
    {
        // Fetch all members
        $members = Member::orderBy('created_at', 'desc')->whereIn('status', ['Active', 'Expire'])->get();
    
        // Initialize an empty array for attendance records
        $attendanceRecords = [];
    
        // Get the attendance month from the request in the format 'YYYY-MM'
        $attendanceMonth = $request->input('attendance_month', today()->format('Y-m'));
    
        // Parse the year and month from the attendanceMonth
        $year = Carbon::parse($attendanceMonth)->year;
        $month = Carbon::parse($attendanceMonth)->month;
    
        // Determine the start and end dates for the specified month
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();
    
        // Calculate the number of days in the month
        $numberOfDays = $endDate->diffInDays($startDate) + 1;
    
        // Retrieve attendance records for the specified month with related members
        $attendanceData = MemberAttendance::with('member')
            ->whereBetween('attendance_date', [$startDate, $endDate])
            ->get()
            ->groupBy('member_id'); // Group attendance records by member ID
    
        // Loop through all members and check their attendance for each day of the month
        foreach ($members as $member) {
            // Initialize attendance status array for the month
            $attendance_status_array = [];
    
            // Loop through each day of the month to check attendance
            for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
                // Check if the attendance data exists for the member
                $attendance = $attendanceData->has($member->id) 
                    ? $attendanceData->get($member->id)->firstWhere('attendance_date', $date->toDateString())
                    : null;
    
                // Check if the member has an attendance record for the current date
                if ($attendance) {
                    $attendance_status_array[] = [
                        'date' => $date->toDateString(),
                        'status' => 'Present',
                    ];
                } else {
                    $attendance_status_array[] = [
                        'date' => $date->toDateString(),
                        'status' => 'Absent',
                    ];
                }
            }
    
            // Add member data along with their attendance status for the month
            $attendanceRecords[] = [
                'member' => $member,
                'attendance_status' => $attendance_status_array,
            ];
        }
    
        $page_mode = 'admin';
    
        // Return the view with data
        return view('admin.pages.member_attendance.monthly_report', [
            'member_attendances' => $attendanceRecords,
            'attendance_report_month' => $month,
            'attendance_report_year' => $year,
            'number_of_days' => $numberOfDays, // Pass the number of days to the view
            'page_mode' => $page_mode,
        ]);
    }
    

  
    public function store(Request $request)
    {
        //
    }

  
    public function show(MemberAttendance $memberAttendance)
    {
        //
    }

   
    public function edit(MemberAttendance $memberAttendance)
    {
        //
    }

   
    public function update(Request $request, MemberAttendance $memberAttendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MemberAttendance  $memberAttendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(MemberAttendance $memberAttendance)
    {
        //
    }
}
