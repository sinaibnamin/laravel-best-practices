<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\CronJobReport;


class CronJobReportController extends Controller {

    public function task_scheduler( Request $request ) {

        $query = CronJobReport::query();

        if ( $request->type != '' ) {
            $query->where( 'type', $request->type );
        }

        if ( $request->error_status != '' ) {
            $query->where( 'error', $request->error_status );
        }

        $cj_reports = $query->orderByDesc('created_at')->paginate( 30 );
        return view( 'admin.pages.automation.task_scheduler' )
        ->with( 'mem_exp_reports', $cj_reports );
    }
}
