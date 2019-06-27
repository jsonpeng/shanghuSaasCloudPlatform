<?php

namespace App\Repositories;

use App\Models\Notice;
use InfyOm\Generator\Common\BaseRepository;
use Config;
use Cache;

/**
 * Class NoticeRepository
 * @package App\Repositories
 * @version April 12, 2018, 10:40 am CST
 *
 * @method Notice findWithoutFail($id, $columns = ['*'])
 * @method Notice find($id, $columns = ['*'])
 * @method Notice first($columns = ['*'])
*/
class NoticeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'content'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Notice::class;
    }

    public function notices($shop_id)
    {
        return Cache::remember('all_notices_'.$shop_id, Config::get('web.cachetime'), function() use ($shop_id){
            return Notice::where('shop_id',$shop_id)
                ->orderBy('created_at', 'desc')
                ->get();
        });
    }

    public function notice($id)
    {
        return Cache::remember('notice_'.$id, Config::get('web.cachetime'), function() use ($id){
            return $this->findWithoutFail($id);
        });
    }
}
