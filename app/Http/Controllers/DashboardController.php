<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Exception;
use Session;
use App\Models\Announcement;
use App\Models\Payment;
use App\Models\Instruction;
use App\Models\PaymentType;
use App\Models\Package;
use App\Models\Member;
use App\Models\Trainer;
use Carbon\Carbon;
use App\Models\ManagementSiteSettings;

class DashboardController extends Controller {

    public function index() {

        $announcements = Announcement::where( 'status', 'Active' )->orderByDesc( 'priority' )->get();
        $total_members = Member::all()->count();
        $total_announcements = Announcement::all()->count();

        $members_count = Member::selectRaw( 'status, COUNT(*) as count' )
        ->groupBy( 'status' )
        ->pluck( 'count', 'status' );
        $active_members = $members_count[ 'Active' ] ?? 0;
        $inactive_members = $members_count[ 'Inactive' ] ?? 0;
        $archive_members = $members_count[ 'Archive' ] ?? 0;
        $pending_members = $members_count[ 'Pending' ] ?? 0;
        $expire_members = $members_count[ 'Expire' ] ?? 0;

        $total_trainers = Trainer::all()->count();
        $total_packages = Package::all()->count();

        $thirtyDaysAgo = Carbon::now()->subDays( 30 );
        $payment_count = Payment::whereBetween( 'date', [ $thirtyDaysAgo, Carbon::now() ] )->where( 'status', 'Success' )
        ->count();
        $due_payment_count = Payment::where( 'due', '>', 0 )->count();

        $gym_routine = ManagementSiteSettings::where( 'id', 1 )->first()->routine ?? 'N/A';

        return view( 'admin.pages.dashboard.admin_dashboard' )
        ->with( 'announcements', $announcements )
        ->with( 'total_packages', $total_packages )
        ->with( 'total_members', $total_members )
        ->with( 'active_members', $active_members )
        ->with( 'inactive_members', $inactive_members )
        ->with( 'pending_members', $pending_members )
        ->with( 'expire_members', $expire_members )
        ->with( 'archive_members', $archive_members )
        ->with( 'total_trainers', $total_trainers )
        ->with( 'payment_count', $payment_count )
        ->with( 'due_payment_count', $due_payment_count )
        ->with( 'total_announcements', $total_announcements )
        ->with( 'gym_routine', $gym_routine );

    }

    public function member_dashboard() {
        $announcements = Announcement::where( 'status', 'Active' )->orderByDesc( 'priority' )->get();
        $member = Member::where( 'phone_number', get_user_id() )->first();
        if ( !$member ) {
            abort( 404 );
        }
        ;
        $gym_routine = ManagementSiteSettings::where( 'id', 1 )->first()->routine;

        $overview = $this->get_member_overview( $member->id );

        $system_name = ManagementSiteSettings::select( 'system_name' )->where( 'id', 1 )->first()->system_name ?? 'Gymnasuim';

        return view( 'admin.pages.dashboard.member_dashboard' )
        ->with( 'announcements', $announcements )
        ->with( 'gym_routine', $gym_routine )
        ->with( 'member', $member )
        ->with( 'overview', $overview )
        ->with( 'system_name', $system_name );

    }

    public function trainer_dashboard() {

        $announcements = Announcement::where( 'status', 'Active' )->orderByDesc( 'priority' )->get();
        $gym_routine = ManagementSiteSettings::where( 'id', 1 )->first()->routine;

        $trainer = Trainer::where( 'phone_number', get_user_id() )->first();
        if ( !$trainer ) {
            abort( 404 );
        }
        ;

        $system_name = ManagementSiteSettings::select( 'system_name' )->where( 'id', 1 )->first()->system_name ?? 'Gymnasuim';

        return view( 'admin.pages.dashboard.trainer_dashboard' )
        ->with( 'announcements', $announcements )
        ->with( 'gym_routine', $gym_routine )
        ->with( 'trainer', $trainer )
        ->with( 'system_name', $system_name );

    }

    public function create() {
        //
    }

    public function store( Request $request ) {
        //
    }

    public function show( $id ) {
        //
    }

    public function edit( $id ) {
        //
    }

    public function update( Request $request, $id ) {
        //
    }

    public function destroy( $id ) {
        //
    }
}
