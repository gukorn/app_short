<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Result;
use App\Models\System\LogError;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{


    public function register()
    {
        return view('auth.register');
    }


    public function saveRegister(Request $request)
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
            $user->save();

            Auth::login($user);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            LogError::saveError($e);
            return Result::message('ไม่ได้สามารถบันทึกได้');
        }

        return Result::url(actionURL('MainController@index'));
    }

}
