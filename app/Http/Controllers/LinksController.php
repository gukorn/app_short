<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\Result;
use App\Models\Master\URLShort;
use App\Models\System\LogEditor;
use App\Models\System\LogError;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LinksController extends Controller
{


    public function index()
    {
        $user = Auth::user();
        $dataLists = URLShort::where('user_id',  $user->id)->where('status',1)->get();
        return view('links.index', compact('dataLists'));
    }

     public function create()
    {
        return view('links.createOrEdit');
    }

    public function store(Request $request)
    {
        if(!empty($request->url_short)){
            $dataCheck = URLShort::where('url_short', $request->url_short)->first();
            if(isset($dataCheck)){
                return Result::message('Short link ซ้ำ');
            }
        }
        $user = Auth::user();
        DB::beginTransaction();
        try {
            $data = new URLShort();
            $data->user_id = $user->id;
            $latestId = URLShort::max('id');
            $data->url_short = $request->url_short?? encode_I($latestId.time());
            $data->url_real = $request->url_real;
            $data->title = $request->title??null;
            $data->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            LogError::saveError($e);
            return Result::message('ไม่ได้สามารถบันทึกได้');
        }
        return Result::url('LinksController@index', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function edit($code)
    {
        $data = URLShort::where('id', decodeI($code))->first();
        return view('links.createOrEdit', compact('data'));
    }

    public function update($code, Request $request)
    {
        if(!empty($request->url_short)){
            $dataCheck = URLShort::where('url_short', $request->url_short)->where('id','!=', decodeI($code))->first();
            if(isset($dataCheck)){
                return Result::message('Short link ซ้ำ');
            }
        }
        DB::beginTransaction();
        try {
            $data = URLShort::where('id', decodeI($code))->first();
            $old_data = $data->replicate();
            $data->url_short = $request->url_short;
            $data->title = $request->title;
            $data->update();
            LogEditor::saveLog($old_data, $data);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            LogError::saveError($e);
            return Result::message('ไม่ได้สามารถบันทึกได้');
        }
        return Result::url('LinksController@index', 'แก้ไขข้อมูลเรียบร้อย');
    }

    public function cancel(Request $request, $code)
    {
        $data = URLShort::where('id', decodeI($code))->first();
        $data_old = $data->replicate();
        $data->update(['status' => config('cache.status.del')]);
        LogEditor::saveLog($data_old, $data, $request->val);
        return Result::url('LinksController@index');
    }

       public function qrcode($code)
    {
        $data = URLShort::where('id', decodeI($code))->first();
        return view('links.qrcode', compact('data'));
    }



}
