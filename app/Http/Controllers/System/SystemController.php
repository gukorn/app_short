<?php

namespace App\Http\Controllers\System;


use App\Http\Controllers\Controller;
use Carbon\Carbon;

class SystemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public static function runBackground()
    {

        $today = Carbon::now()->format('Y-m-d H:i:s');
        // AeEmployee::where('status', config('cache.status.hrm_active'))
        // ->whereNotNull('date_end')
        // ->where('date_end','<=',$today)->update(['status' =>  config('cache.status.hrm_resign')]);
        // foreach ($data as  $value) {
        //     $value->status = config('cache.status.hrm_resign');
        //     $value->update();
        // }

    }
}
