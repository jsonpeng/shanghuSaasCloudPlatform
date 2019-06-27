<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BankCard;
use App\Models\BankSets;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

class BankCardController extends Controller
{
    public function index()
    {
        $bankcards=BankCard::paginate(15);
    	return view(frontView('usercenter.bankcard.index'), compact('bankcards'));
    }

    public function add()
    {
        $bankinfo=BankSets::all();
        return view(frontView('usercenter.bankcard.create'), compact('bankinfo'));
    }

    public function edit($bank_id)
    {
        $bankinfo=BankSets::all();
        $bankcard=BankCard::find($bank_id);
        return view(frontView('usercenter.bankcard.edit'), compact('bankinfo','bankcard'));
    }

    public function ajax_get_bank_info(){
        $bankinfo=BankSets::all();
        if(!empty($bankinfo)) {
            return ['code' => 0, 'message' =>$bankinfo];
            }else{
            return ['code' => 1, 'message' =>'未知错误'];
        }
    }

    public function save_bank_info(Request $request){
        if(!$request->has('name') || !$request->has('type') || !$request->has('bank_name') || !$request->has('user_name') || !$request->has('count') || empty($request->get('name'))  ||  empty($request->get('bank_name')) ||  empty($request->get('user_name'))   || empty($request->get('count'))){
            return ['code' => 1, 'message' =>'信息不完整'];
        }else{
            $input = $request->all();
            if($request->has('bank_id')){
               $bankcard= BankCard::find($input['bank_id']);
               if(!empty($bankcard)){
                   $bankcard->update($input);
               }else{
                   return ['code'=>1,'message'=>'未知错误'];
               }
            }else {

                $user = auth('web')->user();
                $input['user_id'] = $user->id;
                $bankinfo = BankCard::create($input);

        }
            $redirect_url = '/usercenter/bankcards';
            return ['code' => 0, 'message' => $redirect_url];
        }
    }

    public function del_bank_info($id){
        $bankinfo=BankCard::find($id);
        if(!empty($bankinfo)){
            $bankinfo->delete();
            $redirect_url = '/usercenter/bankcards';
            return ['code' => 0, 'message' =>'删除成功','url'=>$redirect_url];
        }else{
            return ['code' => 1, 'message' =>'未知错误'];
        }
    }

    public function bankListToChoose(){
        $bankinfo='';
        return view(frontView('usercenter.bankcard.list'), compact('bankinfo'));
    }


}
