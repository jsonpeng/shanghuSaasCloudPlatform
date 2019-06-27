<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateArticlecatsRequest;
use App\Http\Requests\UpdateArticlecatsRequest;
use App\Repositories\ArticlecatsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Overtrue\Pinyin\Pinyin;

class ArticlecatsController extends AppBaseController
{
    /** @var  ArticlecatsRepository */
    private $categoryRepository;

    public function __construct(ArticlecatsRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * Display a listing of the Articlecats.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $categories = $this->defaultSearchState($this->categoryRepository);

        $categories = $this->accountInfo($categories,false,'asc');
        
        return view('admin.articlecats.index')
            ->with('categories', $categories);
    }

    /**
     * Show the form for creating a new Articlecats.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.articlecats.create');
    }

    /**
     * Store a newly created Articlecats in storage.
     *
     * @param CreateArticlecatsRequest $request
     *
     * @return Response
     */
    public function store(CreateArticlecatsRequest $request)
    {
        $input = $request->all();

        //如果用户没有输入别名，则自动生成
        if (!array_key_exists('slug', $input) || $input['slug'] == '') {
            $pinyin = new Pinyin();
            $input['slug'] = $pinyin->permalink($input['name']);
        }

        //清除空字符串
        $input = array_filter( $input, function($v, $k) {
            return $v != '';
        }, ARRAY_FILTER_USE_BOTH );
        $input = attachAccoutInput($input);
        $category = $this->categoryRepository->create($input);

        Flash::success('保存成功');

        return redirect(route('articlecats.index'));
    }

    /**
     * Display the specified Articlecats.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('信息不存在');

            return redirect(route('articlecats.index'));
        }

        return view('admin.articlecats.show')->with('category', $category);
    }

    /**
     * Show the form for editing the specified Articlecats.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('信息不存在');

            return redirect(route('articlecats.index'));
        }

        return view('admin.articlecats.edit')->with('category', $category);
    }

    /**
     * Update the specified Articlecats in storage.
     *
     * @param  int              $id
     * @param UpdateArticlecatsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateArticlecatsRequest $request)
    {
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('信息不存在');

            return redirect(route('articlecats.index'));
        }

        $input = $request->all();

        //清除空字符串
        $input = array_filter( $input, function($v, $k) {
            return $v != '';
        }, ARRAY_FILTER_USE_BOTH );

        $category = $this->categoryRepository->update($input, $id);

        Flash::success('更新成功');

        return redirect(route('articlecats.index'));
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
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('信息不存在');

            return redirect(route('articlecats.index'));
        }

        $this->categoryRepository->delete($id);

        Flash::success('删除成功');

        return redirect(route('articlecats.index'));
    }

    /*
    *获取分类的根分类
    */
    private function getCatRoot($slugOrId){
        $category = '';
        if (is_numeric($slugOrId)) {
            $category = $this->categoryRepository->getCacheCategory($slugOrId);
        } else {
            $category = $this->categoryRepository->getCacheCategoryBySlug($slugOrId);
        }
        //分类信息不存在
        if (empty($category)) {
            return null;
        }else{
            if ($category->parent_id == 0) {
                return $category;
            } else {
                return $this->getCatRoot($category->parent_id);
            }
        }
    }


}
