<?php

namespace App\Repositories;

use App\Models\Banner;
use InfyOm\Generator\Common\BaseRepository;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

use App\Models\BannerItem;

/**
 * Class BannerRepository
 * @package App\Repositories
 * @version October 17, 2017, 8:45 pm CST
 *
 * @method Banner findWithoutFail($id, $columns = ['*'])
 * @method Banner find($id, $columns = ['*'])
 * @method Banner first($columns = ['*'])
*/
class BannerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'image',
        'link',
        'sort'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Banner::class;
    }

    public function banners()
    {
        return Banner::all();
    }

/*
    public function cachedBanners()
    {
        return Cache::remember('all_banners', Config::get('web.longtimecache'), function() {
            return Banner::all();
        });
        
    }
*/
    public function getBannerCached($slug,$shop_id)
    {
        return Cache::remember('banner_'.$slug.'_'.$shop_id, Config::get('web.cachetime'), function() use ($slug,$shop_id) {
            try {
                //return $shop_id;
                $banner = Banner::where('slug', $slug)
                    ->where('shop_id',$shop_id)
                    ->first();
                //dd($banner);
                if (is_null($banner)) {
                    return collect([]);
                }else{
                    return $banner->bannerItems()->orderBy('sort', 'desc')->get();
                }
            } catch (Exception $e) {
                return collect([]);
            }
        });
    }
}
