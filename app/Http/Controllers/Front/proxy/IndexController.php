<?php

namespace App\Http\Controllers\Front\proxy;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;


class IndexController extends Controller
{

    public function __construct(
      
    )
    {
     
    }

    //代理商首页
    public function index(Request $request){
        $proxy = admin($request->account);
        //dd('代理商'.$proxy->nickname.'的首页');
        return view(frontView('proxy'),compact('proxy'));
    }

    
}
