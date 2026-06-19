<?php

namespace App\Http\Controllers\Admin;

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
        $dataLists = URLShort::where('status',1)->get();
        return view('admin.links.index', compact('dataLists'));
    }

    public function edit($code)
    {
        $data = URLShort::where('id', decodeI($code))->first();
        return view('admin.links.createOrEdit', compact('data'));
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
        return Result::url('Admin\LinksController@index', 'แก้ไขข้อมูลเรียบร้อย');
    }

    public function cancel(Request $request, $code)
    {
        $data = URLShort::where('id', decodeI($code))->first();
        $data_old = $data->replicate();
        $data->update(['status' => config('cache.status.del')]);
        LogEditor::saveLog($data_old, $data, $request->val);
        return Result::url('Admin\LinksController@index');
    }
}
