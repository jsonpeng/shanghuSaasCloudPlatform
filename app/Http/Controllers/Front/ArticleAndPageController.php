<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SettingRepository;
use App\Repositories\ArticlecatsRepository;
use App\Repositories\PostRepository;
use App\Repositories\PostItemsRepository;
use App\Repositories\PageRepository;
use App\Repositories\MenuRepository;
use App\Repositories\MessageRepository;
use App\Repositories\LinkRepository;
use App\Repositories\BannerRepository;
use App\Repositories\CustomPostTypeRepository;
use App\Repositories\CustomPostTypeItemsRepository;
use App\Repositories\CoorperatorRepository;
use App\Repositories\ClientRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Mail;
use App\Models\Post;

class ArticleAndPageController extends Controller
{

    private $categoryRepository;
    private $postRepository;
    private $pageRepository;
    private $customPostTypeRepository;
    private $customPostTypeItemsRepository;
    private $postItemsRepository;
    public function __construct(
        ArticlecatsRepository $categoryRepo,
        PostRepository $postRepo,
        PageRepository $pageRepo,
        CustomPostTypeRepository $customPostTypeRepo,
        CustomPostTypeItemsRepository $customPostTypeItemsRepo,
        PostItemsRepository $postItemsRepo
    )
    {
        $this->categoryRepository = $categoryRepo;
        $this->postRepository = $postRepo;
        $this->pageRepository = $pageRepo;
        $this->customPostTypeRepository=$customPostTypeRepo;
        $this->customPostTypeItemsRepository=$customPostTypeItemsRepo;
        $this->postItemsRepository=$postItemsRepo;
    }


    private function getPostTemplate($cats){
        foreach ($cats as $key => $cat) {
            if (view()->exists('front.'.theme()['name'].'.article_page.post.'.$cat->slug)) {
                return frontView('article_page.post.'.$cat->slug);
            }
        }
        //搜寻三层父类
        foreach ($cats as $key => $cat) {
            if ($cat->parent_id != 0) {
                $parent_cat = $this->categoryRepository->getCacheCategory($cat->parent_id);
                if (view()->exists('front.'.theme()['name'].'.article_page.post.'.$parent_cat->slug)) {
                    return frontView('article_page.post.'.$parent_cat->slug);
                }
                if ($parent_cat->parent_id != 0) {
                    $granpa_cat = $this->categoryRepository->getCacheCategory($parent_cat->parent_id);
                    if (view()->exists('front.'.theme()['name'].'.article_page.post.'.$granpa_cat->slug)) {
                        return frontView('front.article_page.post.'.$granpa_cat->slug);
                    }
                }
            }
        }
        return 'front.article_page.post.index';
    }

    /*
    *根据分类别名，获取可用的模板
    *依次寻找自身分类别名，父分类别名，如果都找不到这返回默认
     */
    private function getCatTemplate($slugOrId){
        $category = '';
        if (is_numeric($slugOrId)) {
            $category = $this->categoryRepository->getCacheCategory($slugOrId);
        } else {
            $category = $this->categoryRepository->getCacheCategoryBySlug($slugOrId);
        }
        //分类信息不存在
        if (empty($category)) {
            return frontView('article_page.cat.index');
        }
        if (view()->exists('front.'.theme()['name'].'.cat.'.$category->slug)) {
            return frontView('article_page.cat.'.$category->slug);
        }else{
            if ($category->parent_id == 0) {
                return frontView('article_page.cat.index');
            } else {
                return $this->getCatTemplate($category->parent_id);
            }
        }
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




    //分类页面
    public function cat(Request $request, $id)
    {

        $category = '';
        if (is_numeric($id)) {
            $category = $this->categoryRepository->getCacheCategory($id);
        } else {
            $category = $this->categoryRepository->getCacheCategoryBySlug($id);
        }

        //分类信息不存在
        if (empty($category)) {

            return redirect('/');
        }

        $cats = $this->categoryRepository->getCacheChildCatsOfParentBySlug($this->getCatRoot($category->id)->slug);

        $posts = $category->posts;

        return view($this->getCatTemplate($category->id))
                ->with('category', $category)
                ->with('cats', $cats)
                ->with('posts', $posts);
    }

    //文章页面
    public function post(Request $request, $id)
    {
        $post = $this->postRepository->getCachePost($id);
        //分类信息不存在
        if (empty($post)) {
            return redirect('/');
        }
        $post->update(['view' => $post->view + 1]);

        //是否为该分类自定义了模板
        //一个文章会属于几个分类
        $cats = $post->cats;
        $posts = $cats->first()->posts()->get();

        return view($this->getPostTemplate($cats))
                ->with('post', $post)
                ->with('posts', $posts);
    }




    //单页面
    public function page(Request $request, $id)
    {
        $page = '';
        if (is_numeric($id)) {
            $page = $this->pageRepository->getCachePage($id);
        } else {
            $page = $this->pageRepository->getCachePageBySlug($id);
        }

        //分类信息不存在
        if (empty($page)) {
            return redirect('/');
        }

        $page->update(['view' => $page->view + 1]);


        //是否为该分类自定义了模板
        if (view()->exists('front.'.theme()['name'].'.page.'.$page->slug)) {
            return view(frontView('article_page.page.'.$page->slug));
        } else {
            return view(frontView('article_page.page.index'))->with('page', $page);
        }
    }

}
