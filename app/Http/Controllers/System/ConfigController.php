<?php

namespace App\Http\Controllers\System;


use App\Http\Controllers\Controller;
use App\Http\Resources\Result;
use App\Models\Master\SyPosition;
use App\Models\System\SyConfig;
use App\Models\System\SyLogError;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {

        $data =  SyConfig::first();
        if (empty($data)) {
            $data = new SyConfig();
            $data->save();
        }
        $dataPosition =  SyPosition::where('status', '>', 0)->orderBy('name', 'asc')->get();
        return view('system.config', compact('data', 'dataPosition'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data =  SyConfig::first();
            $data->driver_position_id = $request->driver_position_id;
            $data->social_security = $request->social_security;

            $data->update();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            SyLogError::saveError($e);
            return Result::message('ไม่สามารถบันทึกข้อมูลได้');
        }
        return Result::url('System\ConfigController@index', 'บันทึกข้อมูลเรียบร้อย');
    }
}
