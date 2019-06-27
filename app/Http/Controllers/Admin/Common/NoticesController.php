<?php

namespace App\Http\Controllers\Admin\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

use Carbon\Carbon;
use Log;
use Config;
use Flash;

class NoticesController extends AppBaseController
{

    public function __construct(
      
    )
    {
       
    }


    public function index(Request $request){
        $notices = allNotices(admin()->id);
        $unreadNotices = allNotices(admin()->id,true);
        $input = $request->all();
        return view('message.index',compact('notices','unreadNotices','input'));
    }


     public function update($id, Request $request)
    {
        $input = $request->all();

        if(array_key_exists('read_all', $input)){
              #更新所有消息
              readedNotice(admin()->id);
        }

        if(array_key_exists('read_at', $input)){
            if(!empty($input['read_at'])){
                $input['read_at']= Carbon::now();
            }
            else{
                $input['read_at'] = null;
            }
            #更新单条消息
            updateNotice(admin()->id,$id,true,$input);
        }
         Flash::success('更新成功');
         return redirect(route('message.index'));
    }

    /**
     * Remove the specified Articlecats from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        
        deleteNotice(admin()->id,true,$id);

        Flash::success('删除成功');

        return redirect(route('message.index'));
    }
 
   

}