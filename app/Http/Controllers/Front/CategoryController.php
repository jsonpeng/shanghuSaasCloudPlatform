<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Category;
use App\Models\Point;
use App\Models\Theme;
use App\Models\Product;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Config;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;

class CategoryController extends Controller
{

    private $categoryRepository;
    private $productRepository;

    public function __construct(CategoryRepository $categoryRepo, ProductRepository $productRepo)
    {
        $this->categoryRepository = $categoryRepo; 
        $this->productRepository = $productRepo;
    }

    /**
     * 分类首页
     * @Author   yangyujiazi
     * @DateTime 2018-03-17
     * @param    Request     $request [description]
     * @param    integer     $id      [description]
     * @return   [type]               [description]
     */
    public function index(Request $request, $id=0){
        $cat_level = getSettingValueByKeyCache('category_level');
        if ($cat_level == 0) {
            //不分类
            $products = $this->productRepository->products();
            return view(frontView('cat.nocat.index'))->with('products',$products);
        } else if($cat_level == 1){
            //一级分类
            return redirect('/category/cat_level_01');
        }else if($cat_level >= 2){
            //二级及以上分类
            $categories = $this->categoryRepository->getTopTwoLevelCats();
            return view(frontView('cat.index'))->with('categories',$categories);
        }
    }

    public function ajaxProducts(Request $request)
    {
        $products = $this->productRepository->products();
    }

    /**
     * 一级分类
     * @Author   yangyujiazi
     * @DateTime 2018-03-17
     * @param    Request     $request [description]
     * @param    [type]      $id      [description]
     * @return   [type]               [description]
     */
    public function level1(Request $request, $id)
    {
        // $page = 1;
        // if ($request->has('page')) {
        //     $page = $request->input('page');
        //     if ($page < 1) {
        //         $page = 1;
        //     }
        // }
        $products = $this->productRepository->getProductsOfCatWithChildrenCatsCached($id);
        $category = $this->categoryRepository->getCategoryByIDCached($id);
        $childrenCats = [];
        $parent_id = 0;
        if ($category->level == 3) {
            return redirect('/category/level1/'.$id);
        }
        if ($category->level == 1) {
            $childrenCats = $this->categoryRepository->getChildCategories($id);
            $parent_id = $category->id;
        }else{
            $childrenCats = $this->categoryRepository->getChildCategories($category->parent_id);
            $parent_id = $category->parent_id;
        }
        return view(frontView('cat.level1'), compact('products', 'childrenCats', 'parent_id', 'id', 'category'));
    }

    public function ajaxLevel1(Request $request, $id)
    {
        $skip = 0;
        $take = 18;

        $inputs = $request->all();
        if (array_key_exists('skip', $inputs)) {
            $skip = intval($inputs['skip']);
        }
        if (array_key_exists('take', $inputs)) {
            $take = intval($inputs['take']);
        }
        $products = $this->productRepository->getProductsOfCatWithChildrenCatsCached($id, $skip, $take);
        return ['code' => 0, 'data' => $products];
    }

    /**
     * 二级分类
     * @Author   yangyujiazi
     * @DateTime 2018-03-17
     * @param    Request     $request [description]
     * @param    [type]      $id      [description]
     * @return   [type]               [description]
     */
    public function level2(Request $request, $id)
    {
        $products = $this->productRepository->getProductsOfCatWithChildrenCatsCached($id);
        $category = $this->categoryRepository->getCategoryByIDCached($id);
        $childrenCats = [];
        $parent_id = 0;
        if ($category->level == 1) {
            return redirect('/category/level1/'.$id);
        }
        if ($category->level == 2) {
            $childrenCats = $this->categoryRepository->getChildCategories($id);
            $parent_id = $category->id;
        }else{
            $childrenCats = $this->categoryRepository->getChildCategories($category->parent_id);
            $parent_id = $category->parent_id;
        }
        return view(frontView('cat.level2'), compact('products', 'childrenCats', 'parent_id', 'id', 'category'));
    }

    /**
     * 一层分类
     * @Author   yangyujiazi
     * @DateTime 2018-03-17
     * @param    Request     $request [description]
     * @param    integer     $cat_id  [description]
     * @return   [type]               [description]
     */
    public function catLevel01(Request $request, $cat_id = 0)
    {
        $categories = $this->categoryRepository->getRootCategoriesCached();
        $products = Product::where('shelf', 1)->orderBy('sort', 'desc');
        if (!empty($cat_id)) {
            $products = $products->where('category_id', $cat_id);
        }
        $products = $products->paginate(18);
        return view(frontView('cat.cat01.index'), compact('products', 'categories', 'cat_id'));
    }

}
