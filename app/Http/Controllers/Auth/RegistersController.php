<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MasterUser;
use App\Models\Prefix;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistersController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;

    public function showRegistrationForm()
    {
        $prefixs = Prefix::all();
        return view('auth.register', compact('prefixs'));
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function registers(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'string', 'max:10', 'unique:users'],
            'prefix' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $masterUser = MasterUser::where('user_id', $request->input('user_id'))->first();
        if($masterUser !== null) {
            $user = User::create([
                'prefix_id' => $request->input('prefix'),
                'user_id' => $request->input('user_id'),
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'email' => strtolower($request->input('email')),
                'role' => $request->input('role'),
                'password' => bcrypt($request->input('password')),
            ]);

            Auth::login($user);
        }

        return redirect()->route('register')->with('error', "อัพเดตข้อมูลเรียบร้อย");
    }
}