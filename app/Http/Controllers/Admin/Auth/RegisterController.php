<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;
use App\Models\Admin;
use Carbon\Carbon;

class RegisterController extends Controller
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

    use RegistersUsers;
    //use AuthenticatesUsers;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/zcjy';
    protected $request;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
      //$this->middleware('guest:admin', ['except' => ['logout','register']]); 
      $this->request=$request;
    }


    protected function guard() 
    { 
        return auth()->guard('admin'); 
    } 

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'mobile' => 'required|string|min:11|unique:admins',
            'nickname' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed'
        ]);
    }


    public function showRegisterForm(Request $request)
    {
        $parent_id = $request->get('parent_id');
        if(empty($parent_id)){
            return redirect('/');
        }
        session()->put('parent_id',$parent_id);
        return view('adminauth.register');
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return Admin::create([
            'nickname' => $data['nickname'],
            'mobile' => $data['mobile'],
            'password' => bcrypt($data['password']),
            'account' =>  app('commonRepo')->accountString(),
            'type' => '商户',
            'parent_id'=>  session('parent_id'),
            'member_end' => Carbon::now()->addDays(14)
        ]);
    }
}
