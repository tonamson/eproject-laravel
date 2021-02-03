<?php

namespace App\Http\Controllers;

use App\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticateController extends Controller
{
    public function getLogin()
    {
        if(auth()->user()) {
            return redirect('/');
        }
        return view('auth.login');
    }

    public function postDoLogin(Request $request)
    {
        $data = $request->all();
        $rule = [
            'id_number' => 'required|exists:staff,id_number',
            'password' => 'required',
        ];
        $message = [];
        $validate = Validator::make($data, $rule, $message);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }
        $id_number = $data['id_number'];
        $password = $data['password'];
        $auth = Auth::attempt(['id_number' => $id_number, 'password' => $password]);
        if ($auth) {
            // login thành công thì redirect tới trang nào đó tùy
            //return response(auth()->user()); // thông tin user
            return redirect('/');
        }
        return redirect()->back()->with('authentication', 'Không tìm thấy thông tin tài khoản');
    }

    public function getLogout(Request $request){
        Auth::logout();
        $request->session()->flush();
        return redirect('auth/login');
    }
}
