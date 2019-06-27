<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Repositories\PostRepository;
use App\Repositories\ArticlecatsRepository;

use App\Http\Controllers\AppBaseController;

use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use Overtrue\Pinyin\Pinyin;
use App\Models\Post;
use Auth;
use Log;

class PostController extends AppBaseController
{
    /** @var  PostRepository */
    private $postRepository;
    private $categoryRepository;
    public function __construct(PostRepository $postRepo,ArticlecatsRepository $categoryRepo)
    {
        $this->postRepository = $postRepo;
        $this->categoryRepository = $categoryRepo;
    }


    public function getCustomType(){
        $customPostTypes = $this->customPostTypeRepository->all();
        return ['status'=>true,'msg'=>$customPostTypes];
    }

    /**
     * Display a listing of the Post.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //$this->postRepository->pushCriteria(new RequestCriteria($request));
        //$posts = $this->postRepository->all();
        $input=$request->all();

        session(['articelListUrl' => $request->fullUrl()]);

        $input = array_filter( $input, function($v, $k) {
            return $v != '';
        }, ARRAY_FILTER_USE_BOTH );

        if (!array_key_exists('cat', $input) || (array_key_exists('cat', $input) && $input['cat'] == '全部')) {
            $posts = Post::orderBy('updated_at', 'desc');
        }else{
            $cat = $this->categoryRepository->getCacheCategory($input['cat']);
            $posts = $cat->posts()->orderBy('updated_at', 'desc');
        }

        if (array_key_exists('name', $input)) {
            $posts=  $posts->where('name', 'like', '%'.$input['name'].'%');
        }
        if (array_key_exists('status', $input) && $input['status'] != '全部') {
            $posts=  $posts->where('status', $input['status']);
        }

        $posts = $this->accountInfo($posts);

        $categories = $this->categoryRepository->all();

        $baseurl = $request->root();

        return view('admin.posts.index')
            ->with('posts', $posts)
            ->with('categories', $categories)
            ->with('baseurl', $baseurl)->withInput($input);
    }

    /**
     * Show the form for creating a new Post.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $input=$request->all();
        $products=[];
        $specs=[];
        $categories = $this->categoryRepository->all();
        return view('admin.posts.create')
            ->with('categories', $categories)
            ->with('images',[])
            ->with('products',$products)
            ->with('specs',$specs)
            ->withInput($input);
    }

    /**
     * 管理员发布
     *
     * @param CreatePostRequest $request
     *
     * @return Response
     */
    public function store(CreatePostRequest $request)
    {
        $input = $request->all();

        $input['is_admin'] = 1;

        $this->storePosts($input,$request);

        Flash::success('保存成功');

        return redirect(route('posts.index'));
    }


    /**
     * 小程序用户发布文章及产品操作
     *
     * @SWG\Get(path="/api/publish_post",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序用户发布文章及产品操作",
     *   description="小程序用户发布文章及产品操作,需要token信息",
     *   operationId="userPublishPostUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *   @SWG\Parameter(
     *     in="formData",
     *     name="shop_id",
     *     type="string",
     *     description="店铺id",
     *     required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回banner图链接列表",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期",
     *     )
     * )
     */
    public function userPublishPost(Request $request){
        $input = $request->all();
  
        #接口请求用户
        $user = auth()->user();

        $input['account'] = $user->account;
        $input['user_id'] = $user->id;
        $input['status'] = 1;
       
        $this->storePosts($input,$request,false);

        return zcjy_callback_data('发布成功');
    }

    /**
     * 小程序用户删除发布的文章
     *
     * @SWG\Get(path="/api/delete_post",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序用户删除发布的文章",
     *   description="小程序用户删除发布的文章,需要token信息",
     *   operationId="userPublishPostUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *   @SWG\Parameter(
     *     in="formData",
     *     name="shop_id",
     *     type="string",
     *     description="店铺id",
     *     required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回banner图链接列表",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期",
     *     )
     * )
     */
    public function deletePublishPost(Request $request){
        $post = $this->postRepository->findWithoutFail($request->input('id'));
        if(!empty($post)){
           $this->deletePostsFunc($post);
           return zcjy_callback_data('删除成功');
        }
        else{
          return zcjy_callback_data('没有该文章',1);
        }
    }
    
    /**
     * [保存文章信息]
     * @param  [type]  $input   [description]
     * @param  [type]  $request [description]
     * @param  boolean $admin   [description]
     * @return [type]           [description]
     */
    private function storePosts($input,$request,$admin=true){
            if($admin){
                $input['user_id']=admin()->id;
                $input = attachAccoutInput($input);
            }

            //清除空字符串
            $input = array_filter( $input, function($v, $k) {
                return $v != '';
            }, ARRAY_FILTER_USE_BOTH );

            if (array_key_exists('content', $input)) {
                $input['content'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['content']);
                $input['content'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['content']);
            }

            if ( !array_key_exists('status', $input) ) {
                $input['status'] = 0;
            }

            if ( !array_key_exists('is_hot', $input) ) {
                $input['is_hot'] = 0;
            }

            if( !array_key_exists('is_admin',$input) ){
                $input['is_admin'] = 0;
            }

            $post = $this->postRepository->create($input);
        
            #关联分类
            if ( array_key_exists('categories', $input) ) {
                $post->cats()->sync($input['categories']);
            }

            #添加附加图片
            if(array_key_exists('post_images',$input)){
                if(!is_array($input['post_images'])){
                    $input['post_images'] = str_replace(['[',']','"'],'',$input['post_images']);
                    $input['post_images'] = explode(',',$input['post_images']);
                }
              $this->postRepository->syncImages($input['post_images'],$post->id);
            }

            #关联商品
            if(array_key_exists('product_spec',$input) && !empty($input['product_spec'])){
                if(!is_array($input['product_spec'])){
                    $input['product_spec'] = str_replace(['[',']','"'],'',$input['product_spec']);
                    $input['product_spec'] = explode(',',$input['product_spec']);
                }
               $this->updateWithProductInfo($input['product_spec'],$post);
            }
         
    }

    /**
     * Display the specified Post.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $post = $this->postRepository->findWithoutFail($id);

        if (empty($post)) {
            Flash::error('信息不存在');

            return redirect(route('posts.index'));
        }

        return view('admin.posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified Post.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Request $request,$id)
    {
        $input=$request->all();
        $post = $this->postRepository->findWithoutFail($id);
        if (empty($post)) {
            Flash::error('信息不存在');

            return redirect(route('posts.index'));
        }

        //dd($post->user()->first());
        $selectedCategories = [];
        $tmparray = $post->cats()->get()->toArray();

        foreach ($tmparray as $key => $val) {
            array_push($selectedCategories, $val['id']);
        }

        $categories = $this->categoryRepository->all();

        #文章的图片
        $images=$this->postRepository->getImages($post);

        #文章关联的商品
        $products=$this->postRepository->getProductListByPostId($id);

        return view('admin.posts.edit')
            ->with('post', $post)
            ->with('selectedCategories', $selectedCategories)
            ->with('categories', $categories)
            ->with('images',$images)
            ->with('products',$products)
        
            ->withInput($input);
    }

    /**
     * Update the specified Post in storage.
     *
     * @param  int              $id
     * @param UpdatePostRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePostRequest $request)
    {
        $post = $this->postRepository->findWithoutFail($id);

        if (empty($post)) {
            Flash::error('信息不存在');

            return redirect(route('posts.index'));
        }

        $input = $request->all();

        if ( !array_key_exists('status', $input) ) {
            $input['status'] = 0;
        }

        if ( !array_key_exists('is_hot', $input) ) {
            $input['is_hot'] = 0;
        }

        if (array_key_exists('content', $input)) {
            $input['content'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['content']);
            $input['content'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['content']);
        }

        $post = $this->postRepository->update($input, $id);

        #分类
        if (array_key_exists('categories', $input)) {
            $post->cats()->sync($input['categories']);
        }else{
            $post->cats()->sync([]);
        }

        #更新附加图片
        if(array_key_exists('post_images',$input)){
          $this->postRepository->syncImages($input['post_images'],$post->id,true);
        }else{
          $this->postRepository->clearImages($id);
        }

        #更新关联商品
        if(array_key_exists('product_spec',$input) && !empty($input['product_spec'])){
            //先清空
            $post->products()->sync([]);
            //然后更新信息
            $this->updateWithProductInfo($input['product_spec'],$post);
        }
        else{
            $post->products()->sync([]);
        }

        Flash::success('更新成功');

      
        return redirect(session('articelListUrl'));
    }

    /**
     * Remove the specified Post from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $post = $this->postRepository->findWithoutFail($id);

        if (empty($post)) {
            Flash::error('信息不存在');

            return redirect(route('posts.index'));
        }

        $this->deletePostsFunc($post);
        
        Flash::success('删除成功.');

        return redirect(session('articelListUrl'));
      
    }

    //删除指定的文章
    private function deletePostsFunc($post){
        #删除基本信息
        $this->postRepository->delete($post->id);

        #删除文章图片
        $this->postRepository->clearImages($post->id);

        #删除关联商品
        $post->products()->sync([]);
    }

    //更新文章关联商品信息
    private function updateWithProductInfo($inputs,$post){
        $specIdArray =  $inputs;
        for ($i = count($specIdArray)-1; $i>=0; $i--) {
            $spec_product=$specIdArray[$i];
            $spec_product_arr=explode('_',$spec_product);
            if($spec_product_arr[1]=="0"){
                $post->products()->attach($spec_product_arr[0]);
            }
        }
    }

}
