<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MasterUser;
use App\Models\Prefix;
use App\Models\User;
use App\Models\Department;
use App\Models\Group;
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
        $departments = Department::all();
        $groups = Group::all();
        return view('auth.register', compact('prefixs', 'departments', 'groups'));
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
     * @param array $data
     * @return \App\Models\User
     */
    public function registers(Request $request)
    {
        $request->validate(
            [
                'user_id' => ['required', 'string', 'max:11', 'unique:users'],
                'prefix' => ['required', 'string', 'max:255'],
                'firstname' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'role' => ['required', 'string', 'max:255'],
                'department' => ['required', 'string', 'max:255'],
                'group' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ],
            [
                'user_id.required' => "กรุณาป้อนรหัสด้วยครับ",
                'user_id.max' => "ห้ามป้อนเกิน 11 ตัว",
                'user_id.unique' => "มีข้อมูลรหัสนี้ในฐานข้อมูลแล้ว",
                'prefix.required' => "กรุณาเลือกคำนำหน้าด้วยครับ",
                'firstname.required' => "กรุณาป้อนชื่อด้วยครับ",
                'lastname.required' => "กรุณาป้อนนามสกุลด้วยครับ",
                'email.required' => "กรุณาป้อนอีเมล์ด้วยครับ",
                'role.required' => "กรุณาเลือกสิทธิ์ด้วยครับ",
                'department.required' => "กรุณาเลือกแผนกด้วยครับ",
                'group.required' => "กรุณาเลือกกลุ่มเรียนด้วยครับ",
                'password.required' => "กรุณาป้อนรหัสผ่านด้วยครับ"
            ]
        );

        $masterUser = MasterUser::where('user_id', $request->input('user_id'))->first();
        if ($masterUser !== null) {
            $user = User::create([
                'prefix_id' => $request->input('prefix'),
                'user_id' => $request->input('user_id'),
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'email' => strtolower($request->input('email')),
                'role' => $request->input('role'),
                'department' => $request->input('department'),
                'group' => $request->input('group'),
                'password' => bcrypt($request->input('password')),
            ]);

            Auth::login($user);
        }

        return redirect()->route('register')->with('error', "อัพเดตข้อมูลเรียบร้อย");
    }
}
