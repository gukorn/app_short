<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Result;
use App\Models\System\LogEditor;
use App\Models\System\LogError;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{


    public function index(Request $request)
    {
        $perPage = $request->input('per_page', config('cache.per_page_main'));
        $dataLists =  User::where('status', '>=', 0)
            ->where(function ($query) {
                if (isset(request()->search)) { // ค้นหาในระบบ
                    $query->orWhere('email', 'like',  '%' . request()->search . '%')
                        ->orWhere('firstname', 'like',  '%' . request()->search . '%')
                        ->orWhere('lastname', 'like',  '%' . request()->search . '%');
                }
            })
            ->orderBy('firstname', 'asc')->paginate($perPage);
        return view('master.user.list', compact('dataLists', 'perPage'));
    }


    public function create()
    {
        return view('master.user.createOrEdit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
        ]);
        $data =  User::where('email', $request->email)->first();
        if (isset($data)) {
            return Result::message("อีเมล์ซ้ำกับในระบบ");
        }

        DB::beginTransaction();
        try {
            $user = new User();
            $user->password = bcrypt($request->password);
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->is_admin = $request->is_admin??0;
            $user->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            LogError::saveError($e);
            return Result::message('ไม่ได้สามารถบันทึกได้');
        }

        return Result::url('Admin\UserController@index', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function edit($code)
    {
        $data = User::find(decodeI($code));
        return view('master.user.createOrEdit', compact('data'));
    }

    public function update($code, Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
        ]);
        $data = User::find(decodeI($code));


        if (!empty($request->password))
            $data->password = bcrypt($request->password);

        $new_data = User::updateOrCreate(
            ['id' => $data->id],
            [
                'password' => $data->password,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
            ]
        );
        LogEditor::saveLog($data, $new_data);
        return Result::url('Admin\UserController@index', 'แก้ไขข้อมูลเรียบร้อย');
    }


    public function cancel(Request $request, $code)
    {
        $data = User::where('id', decodeI($code))->first();
        $data_old = $data->replicate();
        $data->update(['status' => config('cache.status.del')]);
        LogEditor::saveLog($data_old, $data, $request->val);
        return Result::url('Admin\UserController@index');
    }

}
