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

    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt(array('email' => $input['email'], 'password' => $input['password'])))
        {
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
                    return redirect()->route('home');
                    break;
            }
        }else{
            return redirect()->route('login')
                ->with('error','Email-Address And Password Are Wrong.');
        }

    }

    public function logout() {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;

   /* public function redirectTo()
    {
        $role = Auth::user()->role;
        switch ($role) {
            case 'admin':
                return '/admin_dashboard';
                break;
            case 'personnel':
                return '/personnel_dashboard';
                break;
            case 'student':
                return '/student_dashboard';
                break;
            default:
                return '/home';
                break;
        }
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
