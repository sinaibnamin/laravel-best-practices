<?php

namespace App\Traits;

use App\Models\Member;
use App\Models\Payment;

trait GetMemberOverviewTrait
{
    public function get_member_overview($id)
    {
        // Attempt to retrieve the member by ID
        $member = Member::find($id);

        // Handle case where the member is not found
        if (!$member) {
            $overview = new \stdClass();
            $overview->error = 'Member not found';
            $overview->member = null;
            $overview->last_payment = null;
            $overview->last_due_payment = null;
            $overview->last_package = null;
            return $overview;
        }

        // Get the last successful payment
        $last_payment = Payment::where('member_id', $member->id)
            ->where('status', 'Success')
            ->orderBy('date', 'desc')
            ->first();

        // Get the last due payment with a positive due amount
        $last_due_payment = Payment::where('member_id', $member->id)
            ->where('status', 'Success')
            ->where('due', '>', 0)
            ->orderBy('date', 'desc') // Optional: Order by date for the latest due payment
            ->first();

        // Get the last package purchased with a validity period
        $last_package = Payment::with('package')
            ->where('member_id', $member->id)
            ->where('status', 'Success')
            ->whereNotNull('validity')
            ->where('validity', '!=', '')
            ->whereHas('package', function ($query) {
                $query->where('price', '>', 0); // Only consider packages with a price greater than 0
            })
            ->orderBy('date', 'desc')
            ->first();

        // Create an overview object
        $overview = new \stdClass();
        $overview->member = $member;
        $overview->last_payment = $last_payment;
        $overview->last_due_payment = $last_due_payment;
        $overview->last_package = $last_package;

        return $overview;
    }
}
