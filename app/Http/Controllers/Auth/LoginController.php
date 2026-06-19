<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Result;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function showLoginReset()
    {
        return view('auth.reset');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);
        if ($request->email) {
            $email = $request->email;
            $data = User::query()->where('email', $request->email)->first();
            if ($data) {
                $password = rand(100000, 99999);
                // $hash_password = Hash::make($password);
                $hash_password = bcrypt($password);
                $data->password = $hash_password;
                $data->save();

                return Result::url(route('login'));
            } else {
                return Result::message('ไม่พบอีเมลที่คุณระบุ');
            }
        }
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);


        $user = User::where('status', '>', 0)
            ->where(function ($query) use ($request) {
                $query->where('email', $request->username);
            })
            ->first();

        if (isset($user) && (Hash::check($request->password, $user->password))) {
            Auth::login($user);
            return Result::url(request()->goto ?? actionURL('MainController@index'));
        } else {
            return Result::message('ข้อมูลผู้ใช้งานหรือรหัสผ่านผิดพลาด');
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->forget('menu');
        return redirect()->action([LoginController::class, 'login']);
    }

    public function login_qrcode()
    {
        return Result::data(['token' => '123456']);
    }
}
