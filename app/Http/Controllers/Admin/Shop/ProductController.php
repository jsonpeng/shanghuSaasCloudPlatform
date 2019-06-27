<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use phpDocumentor\Reflection\Types\Object_;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use App\Models\Product;
use App\Models\Category;
use App\Models\Word;
use DB;

class ProductController extends AppBaseController
{
    /** @var  ProductRepository */
    private $productRepository;
    private $categoryRepository;
 
    public function __construct(
        ProductRepository $productRepo,
        CategoryRepository $categoryRepo)
    {
        $this->productRepository = $productRepo;
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * Display a listing of the Product.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        session(['productIndexUrl' => $request->fullUrl()]);
        //清除空字符串
        $inventory_warn=empty(getSettingValueByKey('inventory_warn')) ? 0 : getSettingValueByKey('inventory_warn');

        //商品分类
        $cats =  $this->categoryRepository->allAccountCats(admin()->account);
        $input = $request->all();

        $input = array_filter( $input, function($v, $k) {
            return $v != '';
        }, ARRAY_FILTER_USE_BOTH );
        
        $products = [];
        $tools=$this->varifyTools($input);

        $second_cats=[0 => '请选择分类'];
        $third_cats=[0 => '请选择分类'];
        $level01=0;
        $level02=0;
        $level03=0;
        $first_cats= $this->categoryRepository->getRootCatArray();
        $created_desc_status=true;
        if (array_key_exists('type', $input)) {
            //查询特定分类
            $category = $this->categoryRepository->findWithoutFail($input['type']);
            if (empty($category)) {
                return view('admin.products.index')
                    ->with('products', [])->with('cats', $cats)->withInput(Input::all());
            }else{
                $products = Product::orderBy('created_at', 'desc')->where('category_id',$input['type']);

            }
        }else{
            $products = Product::where('id','>','0');
        }
        if(array_key_exists('cat_level01',$input)){
    
                $products = $products->where('category_id',$input['cat_level01']);
            
        }

        if(array_key_exists('product_id_sort',$input)){
            $products = $products->orderBy('id', $input['product_id_sort']=='升序'?'asc':'desc');
            $created_desc_status=false;
        }
        if (array_key_exists('product_name', $input)) {
            $products = $products->where('name', 'like', '%'.$input['product_name'].'%');
        }
        if(array_key_exists('price_start',$input)){
            $products = $products->where('price', '>=', $input['price_start']);
        }
        if(array_key_exists('price_end',$input)){
            $products = $products->where('price', '<=', $input['price_start']);
        }
        if (array_key_exists('price_sort', $input)) {
            $products = $products->orderBy('price', $input['price_sort']=='升序'?'asc':'desc');
            $created_desc_status=false;
        }

        // if (array_key_exists('recommend', $input)) {
        //    $products = $products->where('recommend', $input['recommend']);
        // }
        if (array_key_exists('shelf', $input)) {
            $products = $products->where('shelf', $input['shelf']);
        }
        if (array_key_exists('inventory', $input)) {
            $products = $products->orderBy('inventory', $input['inventory']=='升序'?'asc':'desc');
            $created_desc_status=false;
        }

        if($created_desc_status){
            $products=$products->orderBy('created_at', 'desc');
        }
        $products = $this->accountInfo($products);

        return view('admin.products.index')
            ->with('tools',$tools)
            ->with('inventory_warn',$inventory_warn)
            ->with('products', $products)
            ->with('cats', $cats)
            ->with('first_cats',$first_cats)
            ->with('second_cats', $second_cats)
            ->with('third_cats',$third_cats)
            ->with('level01',$level01)
            ->with('level02',$level02)
            ->with('level03',$level03)
            ->withInput(Input::all());
    }

    /**
     * Show the form for creating a new Product.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->getRootCatArray();

        $services = account(app('commonRepo')->serviceRepo()->model(),admin()->account,true)->get();
    
        //默认库存
        $defaultInventory = getSettingValueByKey('inventory_default');

        return view('admin.products.create')
                ->with('categories', $categories)
                ->with('defaultInventory', $defaultInventory)
                ->with('services',$services)
                ->with('selectedServices',[]);

    }

    /**
     * 关联服务操作
     * @param  [type] $input    [description]
     * @param  [type] $product [description]
     * @return [type]           [description]
     */
    private function attachService($input,$product){
        $flag = true;
        if ( array_key_exists('services_id', $input) && !empty($input['services_id'])) {
            #先置空
            $product->services()->sync([]);
            $services_id_arr = $input['services_id'];
            for($i=count($services_id_arr)-1;$i>=0;$i--){
                if(strpos($services_id_arr[$i],',')!==false){
                 $services_id_arr_more=explode(',',$services_id_arr[$i]);
                  //dd($services_id_arr_more);
                    for($m=count($services_id_arr_more)-1;$m>=0;$m--){
                        $product->services()->attach($services_id_arr_more[$m], ['num' => $input['services_num'][$m]]);
                    }
                }
                else {
                    $product->services()->attach($services_id_arr[$i], ['num' => $input['services_num'][$i]]);
                }
            }
        }
        else{
            $flag = false;
        } 
        return $flag;  
    }



    /**
     * Store a newly created Product in storage.
     *
     * @param CreateProductRequest $request
     *
     * @return Response
     */
    public function store(CreateProductRequest $request)
    {
        $input = $request->all();

        //过滤空数据
        // $input = array_filter( $input, function($v, $k) {
        //     return $v != '';
        // }, ARRAY_FILTER_USE_BOTH );

        if (array_key_exists('intro', $input)) {
            $input['intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
        }
        if (!empty($input['level03'])) {
            $input['category_id'] = $input['level03'];
        }elseif (!empty($input['level02'])) {
            $input['category_id'] = $input['level02'];
        }elseif (!empty($input['level01'])) {
            $input['category_id'] = $input['level01'];
        }else{
            $input['category_id'] = 0;
        }

        #检查关联服务
        if(!array_key_exists('services_id', $input) || array_key_exists('services_id', $input) && empty($input['services_id'])){
             return redirect(route('products.create'))
                        ->withErrors('请选择服务')
                        ->withInput($input);
        }

        #保存account信息
        $input = attachAccoutInput($input);

        #创建商品
        $product = $this->productRepository->create($input);

        #关联服务
        $this->attachService($input,$product);
        
        $request->session()->flash('product_edit_rember',$product->id);

        return redirect(route('products.edit', [$product->id]));
        
    }

    /**
     * Display the specified Product.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error('产品不存在');

            return redirect(route('products.index'));
        }

        $images = $product->images()->get();
        $paras = $product->paras()->get();

        return view('admin.products.show')
            ->with('product', $product)
            ->with('images', $images)
            ->with('paras', $paras);
    }

    /**
     * Show the form for editing the specified Product.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Request $request,$id)
    {
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error('产品不存在');

            return redirect(route('products.index'));
        }
        $first_cats=[0 => '请选择分类'];
        $second_cats=[0 => '请选择分类'];
        $third_cats=[0 => '请选择分类'];
        $level01=-1;
        $level02=-1;
        $level03=-1;
        $categories = $this->categoryRepository->getRootCatArray();
        $images = $product->images;
        $edit_rember=false;
        $spec_show=false;
        
        //要处理商品分类无无分类的情况，就是category_id为0
        if ($request->session()->has('product_edit_rember')) {
            $edit_rember=true;
        }
        if($request->has('spec')){
            $spec_show=true;
        }

        $level01 = $product->category_id;
        
        $selectedServices = [];

        $services=  $product->services()->orderBy('id','asc')->get();

        return view('admin.products.edit', compact('spec_show','edit_rember','images', 'product', 'categories','level','level01', 'level02','level03','fist_cats','second_cats','third_cats','services','selectedServices'));
    }

    /**
     * Update the specified Product in storage.
     *
     * @param  int              $id
     * @param UpdateProductRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error('产品不存在');
            return redirect(route('products.index'));
        }
        $input = $request->all();

        //过滤空数据
        $input = array_filter( $input, function($v, $k) {
            return $v != '';
        }, ARRAY_FILTER_USE_BOTH );

        //$input['price'] = $product->price;
        if (array_key_exists('intro', $input)) {
            $input['intro'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
            $input['intro'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['intro']);
        }

        if (!array_key_exists('shelf', $input)) {
            $input['shelf'] = 0;
        }
        // if (!array_key_exists('recommend', $input)) {
        //     $input['recommend'] = 0;
        // }


        if (!empty($input['level03'])) {
            $input['category_id'] = $input['level03'];
        }elseif (!empty($input['level02'])) {
            $input['category_id'] = $input['level02'];
        }elseif (!empty($input['level01'])) {
            $input['category_id'] = $input['level01'];
        }else{
            $input['category_id'] = 0;
        }
        $inputs=$input;

        #检查关联服务
        if(!$this->attachService($input,$product)){
              return redirect(route('products.edit',$product->id))
                        ->withErrors('请选择服务')
                        ->withInput($input);
        }

        $product = $this->productRepository->update($input, $id);



        Flash::success('产品信息更新成功');

        //return redirect(route('products.index'));
        return redirect(session('productIndexUrl'));
    }

    /**
     * Remove the specified Product from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error('产品不存在');

            return redirect(route('products.index'));
        }

        $this->productRepository->deleteAttachInfoByProduct($product);
        $this->productRepository->delete($id);

        Flash::success('产品删除成功');

        return redirect(route('products.index'));
    }


    public function ajaxGetSpecSelect(Request $request)
    {
        $input = $request->all();
        $input['product_id'] = $input['product_id'];        
        $specList = Spec::where('type_id', $input['spec_type'])->orderBy('sort', 'desc')->get();
        /*
        $specList = M('Spec')->where("type_id = ".I('get.spec_type/d'))->order('`order` desc')->select();
        foreach($specList as $k => $v)        
            $specList[$k]['spec_item'] = M('SpecItem')->where("spec_id = ".$v['id'])->order('id')->getField('id,item'); // 获取规格项                
        */
        foreach ($specList as $item) {
            $item['spec_item'] = $item->items()->get();
        }

        $spec_keys = SpecProductPrice::where('product_id', $input['product_id'])->select("key")->get();
        $items_id = '';
        $index = 1;
        foreach ($spec_keys as $key => $value) {
            if ($index++ != 1) {
                $items_id .= '_';
            }
            $items_id .= $value->key;
        }
       
        //$items_id = M('SpecGoodsPrice')->where('goods_id = '.$product_id)->getField("GROUP_CONCAT(`key` SEPARATOR '_') AS items_id");
        $items_ids = explode('_', $items_id);
        
        // 获取商品规格图片   
        /*             
        if($product_id)
        {
           $specImageList = M('SpecImage')->where("goods_id = $product_id")->getField('spec_image_id,src');                 
        }        
        $this->assign('specImageList',$specImageList);
        
        $this->assign('items_ids',$items_ids);
        $this->assign('specList',$specList);*/
        return view('admin.products.ajax_spec', compact('items_ids', 'specList')); 
    }

    public function ajaxGetAttrInput(Request $request)
    {
        //header("Content-type: text/html; charset=utf-8");
        $input = $request->all();
        $attributeList = ProductAttr::where('type_id', $input['type_id'])->get();                                
        $str = '';

        foreach($attributeList as $key => $val)
        {                                                                        
            $curAttrVal_tmp = $this->productAttrValueRepository->getProductAttrVal(0, $input['product_id'], $val->id);
             //促使他 循环
            if(empty($curAttrVal_tmp)){
                $curAttrVal[] = array('id' =>'','product_id' => '','attr_id' => '','attr_value' => '','attr_price' => '');
            }else{
                $curAttrVal[] = array('id' =>$curAttrVal_tmp->id,'product_id' => $curAttrVal_tmp->product_id,'attr_id' => $curAttrVal_tmp->attr_id,'attr_value' => $curAttrVal_tmp->attr_value);
            }
            
            foreach($curAttrVal as $k =>$v)
            {   
                $str .= sprintf("<tr class=attr_%d>", $val->id);
                $addDelAttr = ''; // 加减符号
                // 单选属性 或者 复选属性
                if($val->attr_type == 1 || $val->attr_type == 2)
                {
                    if($k == 0)                                
                        $addDelAttr .= "<a onclick='addAttr(this)' href='javascript:void(0);'>[+]</a>&nbsp&nbsp";                                                                    
                    else                                
                         $addDelAttr .= "<a onclick='delAttr(this)' href='javascript:void(0);'>[-]</a>&nbsp&nbsp";                               
                }

                $str .= sprintf("<td>%s %s</td> <td>", $addDelAttr, $val->name);
                        
                // 手工录入
                if($val->input_type == 0)
                {
                    $str .= "<input type='text' class='form-control' size='40' value='".$v['attr_value']."' name='attr_".$val->id."[]' />";
                }
                // 从下面的列表中选择（一行代表一个可选值）
                if($val->input_type == 1)
                {
                    $str .= "<select class='form-control' name='attr_".$val->id."[]'><option value='0'>无</option>";
                    $tmp_option_val = explode(' ', $val->values);
                    foreach($tmp_option_val as $k2=>$v2)
                    {
                        // 编辑的时候 有选中值
                        $v2 = preg_replace("/\s/","",$v2);
                        if($v['attr_value']== $v2)
                            $str .= sprintf("<option selected='selected' value='%s'>%s</option>", $v2, $v2) ;
                        else
                            $str .= sprintf("<option value='%s'>%s</option>", $v2, $v2);
                    }
                    $str .= "</select>";                
                }
                // 多行文本框
                if($val->input_type == 2)
                {
                    $str .= "<textarea class='form-control' cols='40' rows='3' name='attr_".$val->id."[]'>".($input['product_id'] ? $v['attr_value'] : $val->values)."</textarea>";
                }                                                        
                $str .= "</td></tr>";       
            } 
            array_pop($curAttrVal);                 
            
        }        
        return  $str;
    }
    public function ajaxDelSpecInputByKey(Request $request){
        $input=$request->all();
        $key_name=$input['key'];
        $spec=SpecProductPrice::where('key',$key_name);
        if($spec->count()>0){
            $spec->delete();
            return ['code'=>0,'message'=>'删除成功'];
        }else{
            return ['code'=>1,'message'=>'该规格信息不存在'];
        }

    }

    public function ajaxGetSpecInput(Request $request, $product_id)
    {
        $input = $request->all();
        $spec_arr = null;
        if (array_key_exists('spec_arr', $input) && $input['spec_arr'] != '') {
            $spec_arr = $input['spec_arr'];
        }else{
            return 
            "<table class='table table-bordered' id='spec_input_tab'><tr><td><b>价格</b></td>
               <td><b>库存</b></td>
               <td><b>SKU</b></td>
               <td><b>图片</b></td>
             </tr></table>";
        }

        foreach ($spec_arr as $k => $v)
        {
            $spec_arr_sort[$k] = count($v);
        }
        asort($spec_arr_sort);        
        foreach ($spec_arr_sort as $key =>$val)
        {
            $spec_arr2[$key] = $spec_arr[$key];
        }
        
        $clo_name = array_keys($spec_arr2);         
        $spec_arr2 = combineDika($spec_arr2); //  获取 规格的 笛卡尔积                 
        /*   
        $spec = M('Spec')->getField('id,name'); // 规格表
        $specItem = M('SpecItem')->getField('id,item,spec_id');//规格项
        $keySpecGoodsPrice = M('SpecGoodsPrice')->where('goods_id = '.$product_id)->getField('key,key_name,price,store_count,bar_code,sku');//规格项
        */
        //var_dump($spec_arr2);
        $spec_tmp = Spec::select('id', 'name')->get();
        $spec = array();
        foreach ($spec_tmp as $key => $value) {
            $spec[$value['id']] = $value['name'];
        }
        $specItem_tmp = SpecItem::select('id','name','spec_id')->get();
        $specItem = array();
        foreach ($specItem_tmp as $key => $value) {
            $specItem[$value->id] = ['item' => $value->name, 'spec_id' => $value->spec_id];
        }

        $keySpecGoodsPrice_tmp = SpecProductPrice::where('product_id', $product_id)->get();
        $keySpecGoodsPrice = array();
        foreach ($keySpecGoodsPrice_tmp as $key => $value) {
            $keySpecGoodsPrice[$value->key] = ['key_name' => $value->key_name, 'inventory' => $value->inventory,'price' => $value->price,'sku' => $value->sku,'image'=>$value->image];
        }
        
        $str = "<table class='table table-bordered form-group' id='spec_input_tab'>";
        $str .="<tr>";       
        // 显示第一行的数据

        foreach ($clo_name as $k => $v) 
        {
           $str .= sprintf(" <td><b>%s</b></td>", $spec[$v]) ;
        }    
        $str .="<td><b>价格</b></td>
               <td><b>库存</b></td>
               <td><b>SKU</b></td>
               <td><b>图片</b></td>
               <td><b>操作</b></td>
             </tr>";
        $i=0;
        // 显示第二行开始 
        foreach ($spec_arr2 as $k => $v) 
        {
            $str .="<tr>";
            $item_key_name = array();
            foreach($v as $k2 => $v2)
            {
                $str .= sprintf("<td>%s</td>", $specItem[$v2]['item']);
                $item_key_name[$v2] = $spec[$specItem[$v2]['spec_id']].':'.$specItem[$v2]['item'];
            }   
            ksort($item_key_name);            
            $item_key = implode('_', array_keys($item_key_name));
            $item_name = implode(' ', $item_key_name);
           // $i++;

            //return $item_key;
            //$keySpecGoodsPrice[$item_key]['price'] ? false : $keySpecGoodsPrice[$item_key]['price'] = 0; // 价格默认为0
            //$keySpecGoodsPrice[$item_key]['inventory'] ? false : $keySpecGoodsPrice[$item_key]['inventory'] = 0; //库存默认为0
            $price = 0;
            if (array_key_exists($item_key, $keySpecGoodsPrice) && array_key_exists('price', $keySpecGoodsPrice[$item_key])) {
                $price = $keySpecGoodsPrice[$item_key]['price'];
            }
            $inventory = 0;
            if (array_key_exists($item_key, $keySpecGoodsPrice) && array_key_exists('inventory', $keySpecGoodsPrice[$item_key])) {
                $inventory = $keySpecGoodsPrice[$item_key]['inventory'];
            }
            $sku = '';
            if (array_key_exists($item_key, $keySpecGoodsPrice) && array_key_exists('sku', $keySpecGoodsPrice[$item_key])) {
                $sku = $keySpecGoodsPrice[$item_key]['sku'];
            }
            $image='';
            if (array_key_exists($item_key, $keySpecGoodsPrice) && array_key_exists('image', $keySpecGoodsPrice[$item_key])) {
                $image = $keySpecGoodsPrice[$item_key]['image'];
            }
             //dd(1);
            //$spec_obj=SpecProductPrice::where('key',$item_key);
            //if($spec_obj->count()){
            $str .= sprintf("<td width=100><input name=item[%s][price] class='form-control' value='%s' onkeyup='this.value=this.value.replace(/[^\d.]/g,\"\")' onpaste='this.value=this.value.replace(/[^\d.]/g,\"\")' /></td>", $item_key, $price);
            $str .= sprintf("<td width=100><input name=item[%s][inventory] class='form-control' value='%s' onkeyup='this.value=this.value.replace(/[^\d-.]/g,\"\")' onpaste='this.value=this.value.replace(/[^\d-.]/g,\"\")'/></td>", $item_key, $inventory);            
            $str .= sprintf("<td width=150><input name=item[%s][sku] class='form-control' value='%s' />
                <input type='hidden' name=item[%s][key_name] value='%s' /></td>", $item_key, $sku, $item_key, $item_name);
            $image_set=empty($image)?'设置':'';
            $str.="<td style='padding: 0;'><a onclick='specimage(this)' data-toggle=modal href=javascript:; data-target=#myModal3 class=btn btn-primary type=button><span>".$image_set."</span><img src='".$image."' alt='' style='width:25px; height: 25px;'></a><input type='hidden' name=item[".$item_key."][image] id='spec_image".$item_key."' value='".$image."' /></td><td style='cursor: pointer;' onclick='del_ajax_model(this)' data-key='".$item_key."'>删除</td>";
            $str .="</tr>";  
        //}
                 
        }
        $str .= "</table>";
        return $str;
    }

    public function ajaxSaveTypeAttr(Request $request, $id)
    {
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            return ['code' => 1, 'message' => '产品不存在'];
        }

        $input = $request->all();
        //过滤异常
        if($input['goods_type']==0){
            SpecProductPrice::where('product_id', $id)->delete();
            $product->update(['type_id' => $input['goods_type']]);
            return ['code' => 0, 'message' => '更新成功'];
        }
        //删除原有规格信息
        SpecProductPrice::where('product_id', $id)->delete();

        //更新模型
        if ($product->type_id != $input['goods_type']) {
            $product->update(['type_id' => $input['goods_type']]);
        }
        if(array_key_exists('item',$input)) {
            //插入信息的规格信息
            foreach ($input['item'] as $key => $item) {
                if ($item['price'] != 0) {
                    SpecProductPrice::create([
                        'key' => $key,
                        'key_name' => $item['key_name'],
                        'price' => $item['price'],
                        'inventory' => $item['inventory'],
                        'sku' => $item['sku'],
                        'product_id' => $id,
                        'image' => $item['image']
                    ]);
                } else {
                    return ['code' => 1, 'message' => '请输入价格'];
                }

            }
        }

        //更新属性信息
        $this->saveGoodsAttr($id, $input['goods_type'], $input);
        
        return ['code' => 0, 'message' => '保存成功'];
    }

    /**
     *  给指定商品添加属性 或修改属性 更新到 tp_goods_attr
     * @param int $product_id  商品id
     * @param int $product_type  商品类型id
     */
    public function saveGoodsAttr($product_id,$product_type, $inputs)
    {  
        //$GoodsAttr = M('GoodsAttr');
        //$Goods = M("Goods");
                
         // 属性类型被更改了 就先删除以前的属性类型 或者没有属性 则删除        
        if($product_type == 0)  
        {
            ProductAttrValue::where('product_id', $product_id)->delete(); 
            return;
        }
        
        $GoodsAttrList = ProductAttrValue::where('product_id' ,$product_id)->get();
        
        $old_goods_attr = array(); // 数据库中的的属性  以 attr_id _ 和值的 组合为键名
        foreach($GoodsAttrList as $k => $v)
        {                
            $old_goods_attr[$v['attr_id'].'_'.$v['product_id']] = $v;
        }            
                          
        // post 提交的属性  以 attr_id _ 和值的 组合为键名    
        $post_goods_attr = array();
        foreach($inputs as $k => $v)
        {
            $attr_id = str_replace('attr_','',$k);
            if(!strstr($k, 'attr_') || strstr($k, 'attr_price_'))
               continue;                                 
            foreach ($v as $k2 => $v2)
            {                      
               $v2 = str_replace('_', '', $v2); // 替换特殊字符
               $v2 = str_replace('@', '', $v2); // 替换特殊字符
               $v2 = trim($v2);
               
               if(empty($v2))
                   continue;
               
               
               $tmp_key = $attr_id."_".$product_id;
               //$post_attr_price = I("post.attr_price_{$attr_id}");
               //$attr_price = $post_attr_price[$k2]; 
               //$attr_price = $attr_price ? $attr_price : 0;
               if(array_key_exists($tmp_key , $old_goods_attr)) // 如果这个属性 原来就存在
               {   
                    /*
                   if($old_goods_attr[$tmp_key]['attr_price'] != $attr_price) // 并且价格不一样 就做更新处理
                   {                       
                        $goods_attr_id = $old_goods_attr[$tmp_key]['goods_attr_id'];                         
                        ProductAttrValue::where("id", $goods_attr_id)->update('attr_price'=>$attr_price);                       
                   }    
                   */
                   ProductAttrValue::where("attr_id", $attr_id)->where('product_id', $product_id)->update(['attr_value'=>$v2]);
               }
               else // 否则这个属性 数据库中不存在 说明要做删除操作
               {
                   ProductAttrValue::create(array('product_id'=>$product_id,'attr_id'=>$attr_id,'attr_value'=>$v2));                       
               }
               unset($old_goods_attr[$tmp_key]);
           }
            
        }     
        // 没有被 unset($old_goods_attr[$tmp_key]); 掉是 说明 数据库中存在 表单中没有提交过来则要删除操作
        foreach($old_goods_attr as $k => $v)
        {                
           ProductAttrValue::where('id', $v['id'])->delete(); // 
        }                       

    }
    //通过商品id获取商品信息
    public function getSingleProductById($id){
        $product=$this->productRepository->findWithoutFail($id);
        return ['code'=>0,'message'=>$product];
    }

    //获取所有规格信息的商品
    public function ajaxGetProductList(Request $request){
        $product=SpecProductPrice::all();
        return ['code'=>0,'message'=>$product];
    }

    public function allLowGoods(Request $request){
        //inventory
        $inventory_warn=empty(getSettingValueByKey('inventory_warn')) ? 0 : getSettingValueByKey('inventory_warn');
        $inputs=$request->all();

        $product=Product::where('id','>',0)->where('inventory','<=',$inventory_warn)->where('inventory','<>',-1)->orderBy('created_at', 'desc');
        $second_cats=[0 => '请选择分类'];
        $third_cats=[0 => '请选择分类'];
        $level01=-1;
        $level02=-1;
        $level03=-1;
        $cats= $this->categoryRepository->getRootCatArray();
        $type='';
        $tools=$this->varifyTools($inputs);
        //$type=1 单选
        if(array_key_exists('type',$inputs)){
            $type='_'.$inputs['type'];
        }
        if(array_key_exists('prom_id',$inputs)) {
            $product=$product->where('prom_type','3')->where('prom_id',$inputs['prom_id']);
        }
        if(array_key_exists('cat_level01',$inputs) || array_key_exists('cat_level02',$inputs) || array_key_exists('cat_level03',$inputs)){
            $inputs['category_id'] = 0;
            if ($inputs['cat_level03']!=0) {
                $inputs['category_id'] = $inputs['cat_level03'];
                $third_cats=[0 => '请选择分类',$inputs['category_id']=>$this->categoryRepository->findWithoutFail($inputs['category_id'])->name];
                $level03= $inputs['category_id'];
            }
            if ($inputs['cat_level02']!=0) {
                $inputs['category_id'] = $inputs['cat_level02'];
                $second_cats=[0 => '请选择分类',$inputs['category_id']=>$this->categoryRepository->findWithoutFail($inputs['category_id'])->name];
                $level02= $inputs['category_id'];
            }
            if ($inputs['cat_level01']!=0) {
                $inputs['category_id'] = $inputs['cat_level01'];
            }
            if($inputs['category_id']!=0) {
                $category_id_arr= $this->categoryRepository->getCategoryLevelByCategoryIdToFindChild($inputs['category_id']);
                // return $category_id_arr;
                $products= $product->whereIn('category_id', $category_id_arr);
            }
        }

        if(array_key_exists('keywords',$inputs)){
            $product=$product->where('name','like', '%' . $inputs['keywords'] . '%');
        }
        $product_list_get=$product->get();
        $products=$product->paginate($this->defaultPage());
        $i=0;
        foreach ($product_list_get as $item){
                $i++;
        }
        $product_num=$i;

        return view('admin.products.all_low'.$type)
            ->with('tools',$tools)
            ->with('cats',$cats)
            ->with('second_cats', $second_cats)
            ->with('third_cats',$third_cats)
            ->with('product',$products)
            ->with('products',$products)
            ->with('product_num',$product_num)
            ->with('level01',$level01)
            ->with('level02',$level02)
            ->with('level03',$level03)
            ->withInput(Input::all());
    }

    public function searchGoodsFrame(Request $request){
        $inputs=$request->all();

        $product=Product::where('id','>',0)->orderBy('created_at', 'desc');
        $second_cats=[0 => '请选择分类'];
        $third_cats=[0 => '请选择分类'];
        $level01=-1;
        $level02=-1;
        $level03=-1;
        $cats= $this->categoryRepository->getRootCatArray();
        $type='';
        $team_sale=false;
        //$type=1 单选
        if(array_key_exists('type',$inputs)){
                $type='_'.$inputs['type'];
        }
        if(array_key_exists('prom_id',$inputs)) {
            $product=$product->where('prom_type','3')->where('prom_id',$inputs['prom_id']);
        }
        if(array_key_exists('team_sale',$inputs)) {
            if(!empty($inputs['team_sale'])){
                $team_sale=true;
            }
        }

        if(array_key_exists('cat_level01',$inputs)){
            $inputs['category_id'] = 0;
    
            if ($inputs['cat_level01']!=0) {
                $inputs['category_id'] = $inputs['cat_level01'];
            }
            if($inputs['category_id']!=0) {
                $category_id_arr= $this->categoryRepository->getCategoryLevelByCategoryIdToFindChild($inputs['category_id']);
                // return $category_id_arr;
                $products= $product->whereIn('category_id', $category_id_arr);
            }
        }

        if(array_key_exists('keywords',$inputs)){
            $product=$product->where('name','like', '%' . $inputs['keywords'] . '%');
        }
        $product_list_get=$product->get();
        $products=$product->paginate($this->defaultPage());
        $i=0;
        foreach ($product_list_get as $item){
                $i++;
        }
        $product_num=$i;
        return view('admin.products.search_tem'.$type)
                    ->with('team_sale',$team_sale)
                    ->with('cats',$cats)
                    ->with('second_cats', $second_cats)
                    ->with('third_cats',$third_cats)
                    ->with('product',$products)
                    ->with('products',$products)
                    ->with('product_num',$product_num)
                    ->with('level01',$level01)
                    ->with('level02',$level02)
                    ->with('level03',$level03)
                    ->withInput(Input::all());
    }



    
}