<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\PostImage;
use InfyOm\Generator\Common\BaseRepository;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

/**
 * Class PostRepository
 * @package App\Repositories
 * @version October 17, 2017, 6:10 pm CST
 *
 * @method Post findWithoutFail($id, $columns = ['*'])
 * @method Post find($id, $columns = ['*'])
 * @method Post first($columns = ['*'])
*/
class PostRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'slug',
        'brief',
        'content',
        'view',
        'seo_title',
        'seo_des',
        'seo_keyword',
        'status',
        'type',
        'more',
        'is_hot'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Post::class;
    }

    /**
     * 获取文章详细信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getCachePost($id){
        return Cache::remember('zcjy_post_'.$id, Config::get('web.cachetime'), function() use ($id) {
            try {
                return Post::find($id);
            } catch (Exception $e) {
                return null;
            }
        });
    }

    public function posts($skip = 0, $take = 18)
    {
        return Cache::remember('posts_'.$skip.'_'.$take, Config::get('web.cachetime'), function() use ($skip, $take) {
            try {
                return Post::orderBy('created_at', 'desc')->skip($skip)->take($take)->get();
            } catch (Exception $e) {
                return null;
            }
        });
    }

    /**
     * 获取文章的第一个分类信息
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function getCachePostFirstCat($id){
        return Cache::remember('zcjy_post_cats_'.$id, Config::get('web.cachetime'), function() use ($id) {
            return $this->getCachePost($id)->cats()->first();
        });
    }

    
    /**
     * 推荐文章
     * @param  [type]  $id     [description]
     * @param  integer $number [description]
     * @return [type]          [description]
     */
    public function getTuijianForId($id,$number=8){
        return Cache::remember('zcjy_post_tuijian_'.$id,Config::get('web.cachetime'),function () use ($id,$number){
            try {
                $posts=Post::where('id','<>', $id);
                if(!empty($posts->get())){
                    return $posts->take($number)->get();
                }else {
                    return collect([]);
                }
            } catch (Exception $e) {
                return;
            }
        });
    }


    /**
     * 上一篇文章
     * @param [type] $id [description]
     */
    public function PrevPost($id)
    {
        return Cache::remember('PrevPost_'.$id, Config::get('web.cachetime'), function() use ($id) {
            $post = $this->getCachePost($id);
            $cat = $this->getCachePostFirstCat($id);
            if (is_null($cat)) {
                return Post::where('id', '<', $id)->where('status', 1)->orderBy('id', 'desc')->first();
            } else {
                $posts = $cat->posts()->where('status', 1)->orderBy('id', 'desc')->get();
                return $posts->first(function ($value, $key) use($id) {
                    return $value->id < $id;
                });
            }
        });
    }

    /**
     * 下一篇文章
     * @param [type] $id [description]
     */
    public function NextPost($id)
    {
        return Cache::remember('NextPost_'.$id, Config::get('web.cachetime'), function() use ($id) {
            $post = $this->getCachePost($id);
            $cat = $this->getCachePostFirstCat($id);
            if (is_null($cat)) {
                return Post::where('id', '>', $id)->where('status', 1)->orderBy('id', 'asc')->first();
            } else {
                $posts = $cat->posts()->where('status', 1)->orderBy('id', 'asc')->get();
                return $posts->first(function ($value, $key) use($id) {
                    return $value->id > $id;
                });
            }
        });
    }

   /**
    * [获取图片 ]
    * @param  [object] $post    [description]
    * @param  [string] $take    [description]
    * @return [type]            [description]
    */
   public function getImages($post,$take='all'){
        if($take=='all'){
            return $post->images()->get();
        }
        return $post->images()->take($take)->get();
   }

   /**
    * [清除文章图片]
    * @param  [int] $post_id    [description]
    * @return [int]             [description]
    */
   public function clearImages($post_id){
        $id=PostImage::where('post_id',$post_id)->delete();
        return $id;
   }

   /**
    * [创建 更新图片]
    * @param  [array]  $images_arr   [description]
    * @param  [int]    $post_id      [description]
    * @param  [bool]   $update       [description]
    * @return [type]                 [description]
    */
   public function syncImages($images_arr,$post_id,$update=false){

        #更新先重置
        if($update){
            $this->clearImages($post_id);
        }

        #只添加的话直接添加
        foreach ($images_arr as $k => $v) {
            if(!empty($v)){
                    PostImage::create([
                        'url'=>$v,
                        'post_id'=>$post_id
                    ]);
            }
        }

   }

    /* 
     * 获取商品列表并且附带规格信息
     */
    public function getProductListByPostId($Post_id){
        $Post=Post::find($Post_id);
        if(!empty($Post)) {
            return $Post->products()->get();
        }else{
            return [];
        }
    }

    /*
     * 仅仅获取规格信息列表
     */
    public function getSpecsListByPostId($Post_id){
        $Post=Post::find($Post_id);
        if(!empty($Post)) {
            return $Post->specs()->get();
        }else{
            return [];
        }
    }
}
