<?php

namespace App\Http\Controllers;

use App\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

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
        $password = md5($data['password']);
        $user = Staff::where(['id_number' => $id_number, 'password' => $password])->first();
        $auth = Auth::login($user);
        if ($auth) {
            // login thành công thì redirect tới trang nào đó tùy
            //return response(auth()->user()); // thông tin user
            $params_get_department = [
                'id' => auth()->user()->id,
            ];
            $response_get_department = Http::get('http://localhost:8888/staff/findOneStaffDepartment', $params_get_department);
            $body_get_department = json_decode($response_get_department->body(), true);

            $request->session()->put('department_name', $body_get_department['data'][0][2]);
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
