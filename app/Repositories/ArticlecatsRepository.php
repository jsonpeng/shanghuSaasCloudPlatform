<?php

namespace App\Repositories;

use App\Models\Articlecats;
use InfyOm\Generator\Common\BaseRepository;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

use DB;
use App\Models\Post;
use Log;

/**
 * Class CategoryRepository
 * @package App\Repositories
 * @version October 17, 2017, 4:39 pm CST
 *
 * @method Category findWithoutFail($id, $columns = ['*'])
 * @method Category find($id, $columns = ['*'])
 * @method Category first($columns = ['*'])
 */
class ArticlecatsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'slug',
        'sort',
        'parent_id',
        'image'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Articlecats::class;
    }


    public function  getCacheCategoryAll($shop_id){
            return Cache::remember('zcjy_category_all_'.$shop_id, Config::get('web.cachetime'), function() use($shop_id){
            try {
                return Articlecats::where('shop_id',$shop_id)->get();
            } catch (Exception $e) {
                return null;
            }
        });
    }

    public function getCacheCategory($idORslug){
        return Cache::remember('zcjy_category_'.$idORslug, Config::get('web.cachetime'), function() use ($idORslug) {
            try {
                if (is_numeric($idORslug)) {
                    return Articlecats::find($idORslug);
                } else {
                    return Articlecats::where('slug', $idORslug)->first();
                }
                return Articlecats::find($id);
            } catch (Exception $e) {
                return null;
            }
        });
    }

    //获取子分类列表 并是否带上文章
    //$withPosts 为true则带文章，false不带
    public function getCacheChildCats($parent_id, $withPosts=false){
        return Cache::remember('zcjy_child_cat_of_'.$parent_id, Config::get('web.cachetime'), function() use ($parent_id,$withPosts) {
            try {
                if ($withPosts) {
                    return Articlecats::where('parent_id', $parent_id)->with('posts')->get();
                } else {
                    return Articlecats::where('parent_id', $parent_id)->get();
                }
            } catch (Exception $e) {
                return collect([]);
            }
        });
    }

    //按层级获取所有的分类信息
    //子分类会排在父分类下方
    public function getCascadeCategories(){
        $origin_categories = Articlecats::where('parent_id', null)->orWhere('parent_id', 0)->get();
        $cascade_categories = collect([]);
        foreach ($origin_categories as $tmp1) {
            $cascade_categories->push($tmp1);
            $origin_categories_tmp = Articlecats::where('parent_id', $tmp1->id)->get();
            foreach ($origin_categories_tmp as $tmp2) {
                $tmp2->name = $tmp2->name;
                $cascade_categories->push($tmp2);
            }
        }
        return $cascade_categories;
    }

    //获取包含自身及子分类的分类信息（自身以及子分类）
    public function getChildCatsOfCatWithParent($cat)
    {
        if (empty($cat)) {
            return collect([]);
        }
        $collection = collect([$cat]);
        $childCats = Articlecats::where('parent_id', $cat->id)->get();
        if ($childCats->count()) {
            foreach ($childCats as $childCat) {
                $childCollection = $this->getChildCatsOfCatWithParent($childCat);
                $collection = $collection->concat($childCollection);
            }
        }
        return $collection;
    }

    /**
     * 获取某个分类下的文章
     * @param  [type]  $idORslug [description]
     * @param  integer $number   [description]
     * @return [type]            [description]
     */
    public function getCachePostOfCat($idORslug, $skip = 0, $take = 18){
        return Cache::remember('zcjy_posts_of_category_id'.$idORslug.'_'.$skip.'_'.$take, Config::get('web.cachetime'), function() use ($idORslug, $skip, $take) {
            try {
                $cat = $this->getCacheCategory($idORslug);
                if ($cat) {
                    return $cat->posts()->skip($skip)->take($take)->get();
                }else{
                    return collect([]);
                }
            } catch (Exception $e) {
                return collect([]);
            }
        });
    }
    /**
     * 获取某分类下的文章，包含子分类
     * @param  [type]  $parentidORslug [description]
     * @param  boolean $withPosts      [description]
     * @return [type]                  [description]
     */
    public function getCachePostOfCatIncludeChildren($category){
        return Cache::remember('get_cache_post_of_cat_include_children'.$category->id, Config::get('web.cachetime'), function() use ($category) {
            try {
                $childCats = $this->getChildCatsOfCatWithParent($category);
                $cat_id_array = array();
                foreach ($childCats as $cat) {
                    array_push($cat_id_array, $cat->id);
                }
                return DB::table('posts')
                    ->join('category_post', 'posts.id', '=', 'category_post.post_id')
                    ->join('categories', 'categories.id', '=', 'category_post.category_id')
                    ->select('posts.*')
                    ->whereIn('categories.id', $cat_id_array)
                    ->where('posts.deleted_at', null)
                    ->get();
            } catch (Exception $e) {
                return collect([]);
            }
        });
    }

    /**
     * 生成适合Form::select展示的array格式
     * 新建产品分类信息
     * @return [type] [description]
     */
    public function getRootCatArray($id = 0){
        $catArray = array(0 => '无分类');
        $categories = Articlecats::select('id', 'name')->where('parent_id', 0)->orWhere('parent_id', null)->get()->toArray();
        while (list($key, $val) = each($categories)) {
            if ($id != $val['id']) {
                $catArray[$val['id']] = $val['name'];
            }
        }
        return $catArray;
    }

    /**
     * 通过别名获取分类信息
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function getCacheCategoryBySlug($slug){
        return Cache::remember('zcjy_category_'.$slug, Config::get('web.cachetime'), function() use ($slug) {
            try {
                return Articlecats::where('slug', $slug)->first();
            } catch (Exception $e) {
                return;
            }
        });
    }


    //获取父分类下的子分类
    public function getCacheChildCatsOfParentBySlug($parent_slug){
        return Cache::remember('child_cat_of_parent_by_slug'.$parent_slug, Config::get('web.cachetime'), function() use ($parent_slug) {
            try {
                $cat = $this->getCacheCategoryBySlug($parent_slug);
                if ($cat) {
                    return Articlecats::where('parent_id', $cat->id)->get();
                }else{
                    return collect([]);
                }
            } catch (Exception $e) {
                return;
            }
        });
    }

    /**
     * 获取指定用户的文章
     */
    public function getUserPosts($user,$skip = 0,$take = 8){
         return Cache::remember('get_user_posts_'.$user->id.$skip.$take, Config::get('web.cachetime'), function() use ($user,$skip,$take) {
            try {
                $posts =Post::where('user_id',$user->id)
                       ->where('is_admin',0)->where('status',1)->skip($skip)->take($take)
                       ->with('images')
                       ->with('user')
                       ->with('products')
                       ->get();

                foreach ($posts as $key => $value) {
                    $value['humanTime'] = $value->created_at->diffForHumans();
                }
                return $posts;
            } catch (Exception $e) {
                return;
            }
        });
    }

    /**
     * 获取所有的文章倒序拿
     * @param  integer $number   [description]
     * @return [type]            [description]
     */
    public function getAllCachePostsWithHot($shop_id,$hot=null,$skip = 0,$take = 8){
        return Cache::remember('zcjy_posts_of_category_all_desc_'.$shop_id.'_'.$hot.'_'.$skip.'_'.$take, Config::get('web.cachetime'), function() use ($shop_id,$hot,$skip,$take) {
            try {
                $posts = collect([]);
                if(empty($hot)){
                    $posts = Post::orderBy('created_at','desc')->where('shop_id',$shop_id)->where('status', 1)->skip($skip)->take($take)
                            ->with('images')
                            ->with('admin')
                            ->with('user')
                            ->with('products')
                            ->get();
                }else{
                    $posts = Post::orderBy('created_at','desc')->where('shop_id',$shop_id)->where('status', 1)->where('is_hot',1)->skip($skip)->take($take)
                            ->with('images')
                            ->with('admin')
                            ->with('user')
                            ->with('products')
                            ->get();
                }
                foreach ($posts as $key => $value) {
                    $value['humanTime'] = $value->created_at->diffForHumans();
                }

                return $posts;
            } catch (Exception $e) {
                return collect([]);
            }
        });
    }



    /**
     * 获取某个分类下的文章倒序拿
     * @param  [type]  $cat_id [description]
     * @param  integer $number   [description]
     * @return [type]            [description]
     */
    public function getCachePostsOfCatIdWithHot($shop_id,$hot=null, $cat_id, $skip = 0, $take = 8){
        return Cache::remember('zcjy_posts_of_category_id_desc_'.$shop_id.'_'.$hot.'_'.$cat_id.'_'.$skip.'_'.$take, Config::get('web.cachetime'), function() use ($shop_id,$hot,$cat_id, $skip, $take) {
            try {
                $posts = collect([]);
                $cat = $this->getCacheCategory($cat_id);
                if ($cat) {
                    if(empty($hot)){
                        $posts = $cat->posts()->where('shop_id',$shop_id)->where('status', 1)->orderBy('created_at','desc')->skip($skip)->take($take)
                            ->with('images')
                            ->with('admin')
                            ->with('products.specs')
                            ->get();
                    }else{
                        $posts = $cat->posts()->where('shop_id',$shop_id)->where('status', 1)->orderBy('created_at','desc')->where('is_hot',1)->skip($skip)->take($take)
                            ->with('images')
                            ->with('admin')
                            ->with('products.specs')
                            ->get();
                    }
                    //Log::info('posts:');
                    //Log::info($posts);
                    foreach ($posts as $key => $value) {
                        $value['humanTime'] = $value->created_at->diffForHumans();
                    }
                    
                    return $posts;
                }else{
                    return collect([]);
                }
            } catch (Exception $e) {
                return collect([]);
            }
        });
    }







}
