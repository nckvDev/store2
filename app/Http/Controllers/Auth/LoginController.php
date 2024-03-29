<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

//    use AuthenticatesUsers;

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $input = $request->all();

         $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => "กรุณาป้อนอีเมล์ด้วยครับ",
                'password.required' => "กรุณาป้อนรหัสผ่านด้วยครับ",
            ]
        );

        if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
            $role = Auth::user()->role;
            switch ($role) {
                case 'admin':
                    return redirect()->route('admin_dashboard');
                    break;
                case 'personnel':
                    return redirect()->route('personnel_dashboard');
                    break;
                case 'student':
                    return redirect()->route('student_dashboard');
                    break;
                default:
                    return redirect()->route('/');
                    break;
            }
        } else {
            return back()->withErrors(['email'=>'อีเมลไม่ถูกต้อง', 'password'=>'รหัสผ่านไม่ถูกต้อง']);
        }

    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /* public function redirectTo()
     {
        //
     }*/
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
