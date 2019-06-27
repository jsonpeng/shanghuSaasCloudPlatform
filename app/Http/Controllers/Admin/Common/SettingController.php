<?php

namespace App\Http\Controllers\Admin\Common;

use App\Http\Requests\CreateSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Repositories\SettingRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Setting;
use Config;

class SettingController extends AppBaseController
{
    /** @var  SettingRepository */
    private $settingRepository;

    public function __construct(SettingRepository $settingRepo)
    {
        $this->settingRepository = $settingRepo;
    }

    /**
     * 打开网站设置页面
     * @return [type] [description]
     */
    public function setting()
    {
        // dd(session(admin()->id.'shop_id'));
        return view('admin.settings.index');
    }

    public function system()
    {
        return view('admin.settings.system');
    }

    //地图设置
     public function map(Request $request){
        $input = $request->all();
        $address=empty($request->get('address'))?'武汉市':$request->get('address');
         return view('admin.settings.map')
                ->with('input',$input)
                ->with('address', $address);
    }
    
    /**
     * 更新设置信息
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function update(Request $request)
    {
        try {
            $inputs = $request->all();
            if(array_key_exists('consume_credits',$inputs)){
                if($inputs['consume_credits']>100){
                    return ['code' => 1, 'message' => '比例不可以大于100'];
                }
            }
            if(array_key_exists('credits_max',$inputs)){
                if($inputs['credits_max']>100){
                    return ['code' => 1, 'message' => '比例不可以大于100'];
                }
            }

            foreach ($inputs as $key => $value) {
                $setting = $this->settingRepository->settingByKey($key);

                $setting->update(['value' => $value]);
            }
            return ['code' => 0, 'message' => '成功'];
        } catch (Exception $e) {
            return ['code' => 1, 'message' => '未知错误'];
        }
        
    }

    public function themeSetting()
    {
        //所有主题
        $themes = Config::get('zcjytheme.theme');
        $theme_colors = Config::get('zcjytheme.theme_color');
        //当前主题
        $curTheme = theme();

        return view('admin.settings.theme', compact('themes', 'curTheme', 'theme_colors'));
    }

    public function themeSettingActive(Request $request, $theme)
    {
        //保存主题
        $setting = $this->settingRepository->settingByKey('theme');
        $setting->update(['value' => $theme]);
        return redirect('/zcjy/settings/themeSetting');
    }

    /**
     * 设置主题颜色
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function postThemeSetting(Request $request)
    {
        if ($request->has('maincolor')) {

            $setting = $this->settingRepository->settingByKey('theme_main_color');
            $setting->value = $request->input('maincolor');
            $setting->save();
        }

        if ($request->has('secondcolor')) {
            $setting = $this->settingRepository->settingByKey('theme_second_color');
            $setting->value = $request->input('secondcolor');
            $setting->save();
        }
        return ['code' => 0, 'message' => '设置成功'];
    }
}
