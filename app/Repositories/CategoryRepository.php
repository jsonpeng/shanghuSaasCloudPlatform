<?php

namespace App\Repositories;

use App\Models\Category;
use InfyOm\Generator\Common\BaseRepository;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class CategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'intro',
        'sort',
        'image',
        'parent_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Category::class;
    }

    //获取账户的全部分类信息
    public function allAccountCats($account,$shop_id=null)
    {
            if(empty($shop_id)){
                $shop_id = now_shop_id();
            }
            return Category::where('account',$account)
            ->where('shop_id',$shop_id)
            ->orderBy('sort', 'asc')
            ->get();
    }



    //获取所有商品根分类信息
    public function getRootOfCat($id){
        return Cache::remember('get_root_of_cat_'.$id, Config::get('web.cachetime'), function() use($id){
            return $this->getParentCatId($id);
        });
    }

    public function getFirstRootCat()
    {
        return Cache::remember('getFirstRootCat', Config::get('web.cachetime'), function() {
            return Category::where('parent_id', 0)->where('status','上线')->orderBy('sort', 'desc')->first();
        });
    }

    private function getParentCatId($id)
    {
        $category = $this->findWithoutFail($id);
        if (empty($category)) {
            return $id;
        }else{
            if ($category->parent_id == 0) {
                return $category->id;
            } else {
                return $this->getParentCatId($category->parent_id);
            }
        }
    }

    //获取所有商品根分类信息
    public function getRootCategoriesCached($shop_id=null){
        return Cache::remember('get_root_product_categories_'.$shop_id, Config::get('web.cachetime'), function() use($shop_id){
            return  Category::where('shop_id',$shop_id)
                ->where('status','上线')
                ->orderBy('sort', 'asc')
                ->get();
        });
    }

    //获取推荐商品分类信息
    public function getRecommendCategoriesCached(){
        return Cache::remember('get_recommend_product_categories', Config::get('web.cachetime'), function() {
            return  Category::where('recommend', 1)->where('status','上线')->orderBy('sort', 'asc')->get();
        });
    }

    //获取子分类信息缓存
    public function getChildCategoriesCached($parent_id){
        return Cache::remember('get_child_categories_'.$parent_id, Config::get('web.cachetime'), function() use($parent_id){
            return  $this->getChildCategories($parent_id);
        });
    }
    //获取子分类信息
    public function getChildCategories($parent_id){
        return  Category::where('parent_id', $parent_id)->where('status','上线')->orderBy('sort', 'asc')->get();
    }

    //获取一二级分类，用户分类展示
    public function getTopTwoLevelCats()
    {
        $rootCats = $this->getRootCategoriesCached();
        foreach ($rootCats as $cat) {
            $cat['children'] = $this->getChildCategoriesCached($cat->id);
        }
        return $rootCats;
    }

    //获取某分类的所有子分类ID
    public function getChildCatIds($parent_id)
    {
        $idArray = [];
        $children = $this->getChildCategories($parent_id);
        if (!empty($children)) {
            foreach ($children as $child) {
                array_push($idArray, $child->id);
                if ($child->level != 3) {
                    $grandchild = $this->getChildCategories($child->id);
                    if (!empty($grandchild)) {
                        foreach ($grandchild as $grand) {
                            array_push($idArray, $grand->id);
                        }
                    }
                }
            }
        }
        return $idArray;
    }

    /*
    //获取父分类下的子分类
    public function getChildCategoriesBySlugCached($parent_slug_name){
        return Cache::remember('category_by_parent_slug_'.$parent_slug_name, Config::get('web.cachetime'), function() use($parent_slug_name){
            $parent_category = $this->getCategoryBySlugCached($parent_slug_name);
            if (empty($parent_category)) {
                return [];
            } else {
                return Category::where('parent_id', $parent_category->id)->get();
            }
        });
    }

    //获取分类下的商品
    
    public function getProductsCached($cat_id){
        return Cache::remember('get_products_of_cat_'.$cat_id, Config::get('web.cachetime'), function() use($cat_id){
            $category = $this->findWithoutFail($cat_id);
            if (empty($category)) {
                return [];
            }
            $products = $category->products()->orderBy('sort', 'asc')->with('dimensions')->get();
            return $products;
        });
    }
    */

    //分批获取分类下的商品
    public function getBunchProductsCached($cat_id, $skip, $take){
        return Cache::remember('getBunchProductsCached'.'_'.$cat_id.'_'.$skip.'_'.$take, Config::get('web.cachetime'), function() use($cat_id, $skip, $take){
            $category = $this->getCategoryByIDCached($cat_id);
            if (empty($category)) {
                return [];
            }
            $products = $category->products()->orderBy('sort', 'asc')->skip($skip)->take($take)->with('dimensions')->get();
            return $products;
        });
    }

    //通过ID获取分类信息
    public function getCategoryByIDCached($id){
        return Cache::remember('get_category_by_id_'.$id, Config::get('web.cachetime'), function() use($id){
            $category = $this->findWithoutFail($id);
            if (empty($category)) {
                return null;
            }
            return $category;
        });
    }

    //通过别名获取分类信息
    public function getCategoryBySlugCached($slug_name){
        return Cache::remember('category_by_slug_'.$slug_name, Config::get('web.cachetime'), function() use($slug_name){
            return Category::where('slug', $slug_name)->first();
        });
    }

    

    //按层级获取所有的分类信息
    public function getCascadeCategories(){
        //return Cache::remember('cascade_categories', Config::get('web.longtimecache'), function(){
            //$origin_categories = Category::where('parent_id', 0)->get();
            $origin_categories=Category::all();
            $cascade_categories = collect([]);
            foreach ($origin_categories as $tmp1) {
                $cascade_categories->push($tmp1);
                //$origin_categories_tmp = Category::where('parent_id', $tmp1->id)->get();
                foreach ($origin_categories_tmp as $tmp2) {
                    $cascade_categories->push($tmp2);
                   // $origin_categories_tmp2 = Category::where('parent_id', $tmp2->id)->get();
                    foreach ($origin_categories_tmp2 as $tmp3) {
                        $cascade_categories->push($tmp3);
                    }
                }
            }
            return $cascade_categories;
        //});
    }

    /**
     * 生成适合Form::select展示的array格式
     * 新建产品分类信息
     * @return [type] [description]
     */
    public function getCatArray($id = 0){
        $catArray = array(0 => '请选择分类');
        $categories = Category::select('id', 'name')->get()->toArray();
        if(count($categories)){
            while (list($key, $val) = each($categories)) {
                if ($id != $val['id']) {
                    $catArray[$val['id']] = $val['name'];
                }
            }
        }
        return $catArray;
    }

    /**
     * 生成适合Form::select展示的array格式
     * 新建产品分类信息
     * @return [type] [description]
     */
    public function getRootCatArray($id = 0){
        $catArray = array(0 => '请选择分类');
        //->where('parent_id', $id)
        $categories = Category::where('account',admin()->account)->select('id', 'name')->get()->toArray();
        if(count($categories)){
            foreach ($categories as $key => $val) {
                $catArray[$val['id']] = $val['name'];
            }
            // while (list($key, $val) = each($categories)) {
            //     if ($id != $val['id']) {
            //         $catArray[$val['id']] = $val['name'];
            //     }
            // }
        }
        return $catArray;
    }

    /**
     * 产品分类选择信息
     * @return [type] [description]
     */
    public function getCascadeCatArray(){
        $tmp_categories = $this->getCascadeCategories();
        $categories = array(0 => '请选择分类');
        $tmp_categories->each(function ($item, $key) use(&$categories) {
            $categories[$item['id']] = $item['name'];
        });
        return $categories;
    }

    //删除子分类
    public function deleteChildCats($parent_category)
    {
        $parent_path = $parent_category->parent_path.'_'.$parent_category->id;
        Category::where('parent_path', 'like', $parent_path.'%')->delete();
    }


    //从子id开始找父id仅得到当前开始的结果
    public function getCategoryLevelByCategoryId($id){
        $category = $this->findWithoutFail($id);
        if (empty($category)) {
            return null;
        }
        if ($category->level == 1) {
            return $category->id;
        } else {
            $tmp = $category->parent_path.'_'.$category->id;
            return substr($tmp, 2, strlen($tmp)-2);
        }
    }

    //从父id开始找子id 得到完整的结果
    public function getCategoryLevelByCategoryIdToFindChild($id){
        $category = $this->findWithoutFail($id);
        if (empty($category)) {
          return [];
        }
        if ($category->level == 1) {
              return  $this->getCategoryAllLevelByLevelOne($category->id);
        } else {
            if($category->level==2){
                $tmp = $this->getCategoryAllLevelByLevelOne($category->id);
                return $tmp;
            }else{
                $tmp=$category->parent_path.'_'.$category->id;
                $tmp= substr($tmp, 2, strlen($tmp)-2);
                $tmp_arr=explode('_',$tmp);
                return $tmp_arr;
            }
        }
    }

    //适用于只有第一级或者第二级分类id想获取所有级的
    public function getCategoryAllLevelByLevelOne($level1,$return_arr=true){
        $level02=0;
        $level03=0;
        $cat = $this->findWithoutFail($level1);
        if (empty($cat)) {
            return [];
        }
        $level01=$cat->id;
        //开始找子分类 找不到就找父分类
        $child_cat=Category::where('parent_id',$level1);
        if(($child_cat->count())){
            $level02=$child_cat->first()->id;
            //子分类如果还有分类就继续找
            $third_child_cat=Category::where('parent_id',$level02);
            if(($third_child_cat->count())){
                $level03=$third_child_cat->first()->id;
            }
        }else{
            $parent_cat_id=$cat->parent_id;
            if($parent_cat_id!=0){
                $level02=$parent_cat_id;
                //接下来找这个分类有没有父分类
                $thid_parent_cat=Category::find($level02);
                if($thid_parent_cat->parent_id!=0){
                    $level03=$thid_parent_cat->parent_id;
                }
            }
        }
        $cat_str= $level01.'_'.$level02.'_'.$level03;
        $cat_arr=explode('_',$cat_str);
        if($return_arr) {
            return $cat_arr;
        }else{
            return $cat_str;
        }
    }

    //更新分类的所有子分类的关系
    public function updateCategoryAllChildRelation($category){
        //开始找子分类 找不到就找父分类
        $level=$category->level;
        $child_cat=Category::where('parent_id',$category->id);
        if(($child_cat->count())){
            $child_cat->update(['level'=>$level+1,'parent_path'=>$category->parent_path.'_'.$category->id]);
            $child_cat_all=$child_cat->get();
            foreach ($child_cat_all as $cat){
                $third_child_cat=Category::where('parent_id',$cat->id);
                if(($third_child_cat->count())){
                    $third_child_cat->update(['level'=>$level+2,'parent_path'=>$cat->parent_path.'_'.$category->id]);
                }
            }
        }
    }

    //查找分类的子分类中是否有第三级
    public function findCategoryChildWhetherHasLevel3($category_id){
        $cat_arr=$this->getChildCatIds($category_id);
        //dd($cat_arr);
        $status=false;
        foreach ($cat_arr as $cat){
            $category=$this->findWithoutFail($cat);
            if(!empty($category)) {
                if ($category->level == 3) {
                    $status = true;
                }
            }
        }
        return $status;
    }


    /**
     * 获取自身ID和子分类ID的合集 返回ID数组
     * @param  [type] $category_id [description]
     * @return [type]              [description]
     */
    public function getCatArrById($category_id){
        $category=$this->findWithoutFail($category_id);
        $cat_arr=[$category_id];
        if(!empty($category)){
          $parent_path = '';
            if ($category->level == 1) {
                $parent_path = '0_'.$category->id;
            }else{
                $parent_path = $category->parent_path.'_'.$category->id;
            }

            $cats = Category::where('parent_path', 'like', '%'.$parent_path.'%')->get();

            foreach ($cats as $v) {
                  array_push($cat_arr,$v->id);
            }
        }
        return $cat_arr;
    }

}


        