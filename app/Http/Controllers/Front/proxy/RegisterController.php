<?php

namespace App\Http\Controllers\Front\proxy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

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
        $parent_id = admin($request->account)->id;
        if(empty($parent_id)){
            return redirect('/');
        }
        session()->put('parent_id',$parent_id);
        return view('adminauth.register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $admin = $this->create($request->all());

        #注册成功告诉管理员
        sendGroupNotice(tag($admin->nickname).'成功通过'.'代理商'.tag(admin($request->account)->nickname).'的'.tag('注册链接').'注册成为商户',null);
        
        #注册成功告诉对应的代理商
        sendNotice(admin($request->account)->id,tag($admin->nickname).'成功通过'.'你的'.tag('注册链接').'注册成为商户');

        return redirect(http().domain().'/zcjy/login?account='.$admin->account);
             
    
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        
        $admin= Admin::create([
            'nickname' => $data['nickname'],
            'mobile' => $data['mobile'],
            'password' => bcrypt($data['password']),
            'account' =>  app('commonRepo')->accountString(),
            'type' => '商户',
            'parent_id'=>  session('parent_id'),
            'member_end' => Carbon::now()->addDays(shop_account_times())
        ]);
        app('commonRepo')->adminPackageRepo()->generateAdminPackage($admin->id);
        //generateAdminPackage
        //Cookie::make('shanghu',$admin->account,1);
        return  $admin;
    }
}
