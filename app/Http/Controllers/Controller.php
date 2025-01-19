<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
use App\Traits\FlashMessageTrait;
use App\Traits\ImageUploaderTrait;
use App\Traits\GetMemberOverviewTrait;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, FlashMessageTrait, ImageUploaderTrait, GetMemberOverviewTrait;

}
