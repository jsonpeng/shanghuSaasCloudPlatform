<?php

namespace App\Repositories;

use App\Models\SingelPage;
use InfyOm\Generator\Common\BaseRepository;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

/**
 * Class SingelPageRepository
 * @package App\Repositories
 * @version February 27, 2018, 3:10 pm CST
 *
 * @method SingelPage findWithoutFail($id, $columns = ['*'])
 * @method SingelPage find($id, $columns = ['*'])
 * @method SingelPage first($columns = ['*'])
*/
class SingelPageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'slug',
        'content',
        'view'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SingelPage::class;
    }

    public function getCacheSinglePageBySlug($slug){
        return Cache::remember('zcjy_single_page_'.$slug, Config::get('web.cachetime'), function() use ($slug) {
            try {
                return SingelPage::where('slug', $slug)->first();
            } catch (Exception $e) {
                return null;
            }
        });
    }

    public function descToShow()
    {
        return SingelPage::orderBy('created_at', 'desc')->get();
    }
}
