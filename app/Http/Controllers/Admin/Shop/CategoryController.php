<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\CategoryRepository;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Product;
use App\Models\Category;
use Pinyin;

class CategoryController extends AppBaseController
{
    /** @var  CategoryRepository */
    private $categoryRepository;


    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
 
    }


    /**
     * Display a listing of the Category.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $categories = $this->categoryRepository->allAccountCats(admin()->account);
        
        return view('admin.categories.index')->with('categories', $categories);
    }

    /**
     * Show the form for creating a new Category.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.categories.create')
            ->with('categories', $this->categoryRepository->getRootCatArray())
            ->with('second_categories', array(0 => '请选择分类'))
            ->with('disable',false)
            ->with('category',null);

    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CreateCategoryRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $input = $request->all();
        //处理别名
        if (!array_key_exists('slug', $input) || empty($input['slug'])) {
            $input['slug'] = Pinyin::permalink($input['name']);
        }
        $input['parent_path'] = '0';
        $input['level'] = 1;
        
        if (array_key_exists('level01', $input) && $input['level01'] != 0) {

            if (array_key_exists('level02', $input) && $input['level02'] != 0) {
                //三级分类
                $input['parent_id'] = $input['level02'];
                $input['parent_path'] .= '_';
                $input['parent_path'] .= $input['level01'];
                $input['parent_path'] .= '_';
                $input['parent_path'] .= $input['level02'];
                $input['level'] = 3;
            }else{
                //二级分类
                $input['parent_id'] = $input['level01'];
                $input['parent_path'] .= '_';
                $input['parent_path'] .= $input['level01'];
                $input['level'] = 2;
            }

        }else{
            //没有父级分类
        }
        $input = attachAccoutInput($input);
        $category = $this->categoryRepository->create($input);

        //Flash::success('商品分类创建成功');
        flash('商品分类创建成功')->success();

        return redirect(route('categories.index'));
    }

    /**
     * Display the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);
        if (empty($category)) {
            Flash::error('商品分类信息没有找到');

            return redirect(route('categories.index'));
        }

        return view('admin.categories.show')->with('category', $category);
    }

    /**
     * Show the form for editing the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('商品分类信息没有找到');

            return redirect(route('categories.index'));
        }
        // $level01 = 0;
        // $level02 = 0;
        // //二级分类
        // if ($category->level == 2) {
        //     $level01 = $category->parent_id;
        // }
        // //二级以上分类
        // if ($category->level > 2) {
        //     $paths = explode('_',$category->parent_path);
        //     $level01 = $paths[count($paths)-2];
        //     $level02 = $paths[count($paths)-1];
        // }
        // $disable=$this->categoryRepository->findCategoryChildWhetherHasLevel3($id) && $category->level==1;
        return view('admin.categories.edit')
            // ->with('disable',$disable)
            ->with('category', $category)
            // ->with('level01', $level01)
            // ->with('level02', $level02)
            ->with('categories', $this->categoryRepository->all());
            // ->with('second_categories', $this->categoryRepository->getRootCatArray($level01))
    }

    /**
     * Update the specified Category in storage.
     *
     * @param  int              $id
     * @param UpdateCategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoryRequest $request)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('商品分类信息没有找到');

            return redirect(route('categories.index'));
        }

        $input = $request->all();
        //处理别名
        if (!array_key_exists('slug', $input) || empty($input['slug'])) {
            $input['slug'] = Pinyin::permalink($input['name']);
        }
        $input['parent_path'] = '0';
        $input['level'] = 1;
        if (!array_key_exists('level02', $input)) {
            $input['level02'] = 0;
        }
        if (!array_key_exists('level01', $input)) {
            $input['level01'] = 0;
        }
        if ($input['level02'] == 0) {
            if ( $input['level01'] ) {
                $input['parent_id'] = $input['level01'];
                $input['parent_path'] .= '_';
                $input['parent_path'] .= $input['level01'];
                $input['level'] = 2;
            }            
        } else {
            $input['parent_id'] = $input['level02'];
            $input['parent_path'] .= '_';
            $input['parent_path'] .= $input['level01'];
            $input['parent_path'] .= '_';
            $input['parent_path'] .= $input['level02'];
            $input['level'] = 3;
        }
        //return $this->categoryRepository->getChildCatIds($id);
        //return $input;

        $category = $this->categoryRepository->update($input, $id);
        //$this->categoryRepository->updateCategoryAllChildRelation($category);


        Flash::success('商品分类信息更新成功');

        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified Category from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('分类信息没有找到');
            return redirect(route('categories.index'));
        }

        //如果有子分类就不能删
        if ($this->categoryRepository->getChildCategories($id)->count()) {
            Flash::error('该分类下有子分类，不能删除');
            return redirect(route('categories.index'));
        }
        
        //将该分类下的商品设置为其父分类或无分类产品
        if ($category->parent_id) {
            Product::where('category_id', $id)->update(['category_id' => $category->parent_id]);
        } else {
            Product::where('category_id', $id)->update(['category_id' => 0]);
        }
        
        // $all_cat_attr = $this->categoryRepository->getCategoryLevelByCategoryIdToFindChild($id);
        // if($category->level=='1'){
        //    $products= Product::whereIn('category_id',$all_cat_attr)->update(['category_id'=>0]);
        // }else if($category->level=='2'){
        //    $products=Product::whereIn('category_id',$all_cat_attr)->update(['category_id'=>$category->parent_id]);
        // }else if($category->level=='3'){
        //     $products=Product::whereIn('category_id',$all_cat_attr)->update(['category_id'=>$category->parent_id]);
        //     //return $products;
        // }
        // $this->categoryRepository->deleteChildCats($category);
        $this->categoryRepository->delete($id);

        Flash::success('分类信息已经删除');

        return redirect(route('categories.index'));
    }

    public function categoriesOfParent($parent_id)
    {
        $childCategories = $this->categoryRepository->getChildCategories($parent_id);
        return $childCategories;
    }
}
