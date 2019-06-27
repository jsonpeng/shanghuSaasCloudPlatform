<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\ArticlecatsRepository;
use App\Repositories\CustomPostTypeRepository;
use App\Repositories\PostRepository;
use App\Repositories\SingelPageRepository;

class PostController extends Controller
{

	private $categoryRepository;
    private $customPostTypeRepository;
    private $postRepository;
    private $singelPageRepository;

    public function __construct(
    	ArticlecatsRepository $categoryRepo,
    	CustomPostTypeRepository $customPostTypeRepo, 
    	SingelPageRepository $singelPageRepo,
    	PostRepository $postRepo
    )
    {
        $this->categoryRepository = $categoryRepo;
        $this->customPostTypeRepository=$customPostTypeRepo;
        $this->postRepository = $postRepo;
        $this->singelPageRepository=$singelPageRepo;
    }
	/**
	 * 文章分类页面
	 * @param  Request $request [description]
	 * @param  [type]  $cat_id  [description]
	 * @return [type]           [description]
	 */
	public function postCats(Request $request, $cat_id = null)
	{
		//所有的分类信息
		$postCats = $this->categoryRepository->getCacheChildCats(0);

		$posts = collect([]);

		if (empty($cat_id) && !empty($postCats)) {
			$cat_id = $postCats->first()->id;
			$posts = $this->categoryRepository->getCachePostOfCat($cat_id);
		}else{
			$posts = $this->postRepository->posts();
		}
		//当前分类下的文章
		
		return view(frontView('post.cats'), compact('cat_id', 'posts', 'postCats'));
	}

	/**
	 * 文章列表页面
	 * @param  Request $request [description]
	 * @param  [type]  $cat_id  [description]
	 * @return [type]           [description]
	 */
	public function posts(Request $request, $cat_id = null)
	{
		return view(frontView('post.posts'));
	}

	/**
	 * 文章详情页面
	 * @param  Request $request [description]
	 * @param  [type]  $post_id [description]
	 * @return [type]           [description]
	 */
	public function postDetail(Request $request, $id)
	{
		$post = $this->postRepository->getCachePost($id);
        //分类信息不存在
        if (empty($post)) {
            return redirect('/');
        }
        $post->view += 1;
        $post->save();

        $cat = $post->cats()->first();

		return view(frontView('post.post_detail'), compact('post', 'cat'));
	}

	//商城单页面
    public function page($slug){
        $page=$this->singelPageRepository->getCacheSinglePageBySlug($slug);
        if(!empty($page)){
               return view(frontView('post.page'))
                ->with('page',$page);
        }else{
            return redirect('/');
        }
    }
}
