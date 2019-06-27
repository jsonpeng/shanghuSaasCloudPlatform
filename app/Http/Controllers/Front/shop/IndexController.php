<?php

namespace App\Http\Controllers\Front\shop;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;


class IndexController extends Controller
{

    public function __construct(
      
    )
    {
     
    }

    //商户首页
    public function index(Request $request){

        $shop = admin($request->account);
    	//dd('商户'.$shop->nickname.'的首页');
        return view(frontView('shop'),compact('shop'));
    }

    
}
