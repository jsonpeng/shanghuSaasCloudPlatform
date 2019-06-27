@extends('admin.layouts.app_shop')

@include('admin.products.partials.css')

@section('content')

<div class="content container-fluid">
    <input type="hidden" name="product_id" value="{{ $product->
    id }}">
       @include('adminlte-templates::common.errors')
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li>
                <a href="javascript:;">
                    <span style="font-weight: bold;">产品设置</span>
                </a>
            </li>
            <li class="{!! !$edit_rember && !$spec_show ? 'active': '' !!}">
                <a href="#tab_1" data-toggle="tab">通用设置</a>
            </li>
            <li class="{!! $edit_rember ? 'active' : '' !!}">
                <a href="#tab_2" data-toggle="tab">产品相册</a>
            </li>
      {{--       <li class="{!! $spec_show ? 'active' : '' !!}">
                <a href="#tab_3" data-toggle="tab">产品模型</a>
            </li> --}}
            <!--li>
                <a href="#tab_4" data-toggle="tab">多件打折</a>
            </li-->
        </ul>
        <div class="tab-content">
            <div class="tab-pane {!! !$edit_rember && !$spec_show ? 'active' : '' !!}" id="tab_1">
                <div class="box ">
                    <!-- form start -->
                    <div class="box-body">
                        {!! Form::model($product, ['route' => ['products.update', $product->id], 'method' => 'patch']) !!}
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="box box-primary mb10-xs">
                                    <div class="box-body">
                                        <div class="form-group">
                                              <label for="name">产品名称<span class="bitian">(必填):</span></label>
                                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('remark', '产品简介:') !!}
                                                {!! Form::textarea('remark', null, ['class' => 'form-control']) !!}
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('image', '图片:') !!}
                                            <div class="input-append">
                                                <!--input id="fieldID4" type="text" value=""-->
                                                {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
                                                <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button">更改</a>
                                                <img src="{{ $product->image }}" style="max-width: 100%; max-height: 150px; display: block;"></div>
                                        </div>

                                        <div class="form-group">
                                            {!! Form::label('category', '产品分类:') !!}
                                            <div class="row">
                                                <div class="col-xs-4 col-sm-4 pr0-xs">
                                                    {!! Form::select('level01',$categories, $level01 , ['class' => 'form-control level01']) !!}
                                                </div>
                                            </div>
                                        </div>

                                         <div class="form-group " style="overflow: hidden;">
                                                <label for="services">选择服务<span class="bitian">(必选):</span></label>
                                               <button class="btn btn-primary btn-sm daterange " type="button" title="选择服务" onclick="addServiceMenuFunc()"> <i class="fa fa-plus"></i>
                                               </button>
                    
                                        </div>

                                        <div id="services_items" class="form-group" style="display:{!! empty($product) ?'none':'block' !!};margin-top:20px;">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">关联服务信息</h3>
                                                </div>
                                                <div  class="box-body" >
                                                    <div class="row" style="background-color: #edfbf8;">
                                                        <div class="col-md-3 col-xs-3">服务名称</div>
                                                        <div class="col-md-3 col-xs-3">服务数量(次)</div>
                                                  {{--       <div class="col-md-4 col-xs-4">服务价格(元)</div> --}}
                                                        <div class="col-md-2 col-xs-2">操作</div>
                                                    </div>
                                                    @if (!empty($product))
                                                         @if(count($services)) 
                                                             @foreach($services as $item)
                                                                <div class="items row" style="border-bottom: 1px solid #f4f4f4" data-id="{!! $item->id !!}">
                        
                                                                        <div class="col-md-3 col-xs-3">
                                                                            {{ $item->name }}
                                                                        </div>

                                                                        <div class="col-md-3 col-xs-3"><span onclick="serviceNumControl(this,'del','num')" style="font-size:24px;">-</span><input name="services_num[]" value="{!! $item->pivot->num !!}" onkeyup="serviceInputControl(this)"><span onclick="serviceNumControl(this,'add','num')" style="font-size:24px;">+</span>
                                                                        </div>

                                                                 {{--        <div class="col-md-4 col-xs-4" >
                                                                           <span onclick="serviceNumControl(this,'del','price')" style="font-size:24px;">-</span><input name="services_price[]" onkeyup="serviceInputControl(this)" value="{!! $item->pivot->price !!}"><span onclick="serviceNumControl(this,'add','price')" style="font-size:24px;">+</span>
                                                                        </div> --}}

                                                                        <div class="col-md-2 col-xs-2">
                                                                            <div class='btn-group' id="item_" style="padding: 8px;">
                                                                                <a href="javascript:;" class='btn btn-danger btn-xs'  onclick="delServiceItem(this)"> <i class="glyphicon glyphicon-trash" title="确认"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" name="services_id[]" value="{{ $item->id }}" />
                                                                </div>
                                                             @endforeach
                                                         @endif
                                                    @endif
                                                </div>
                                        </div>

                                        <div id="services_items_table" style="display:none;"></div>

                                        <div class="row">
                                            <div class="form-group col-xs-4">
                                                <label for="name">产品价格<span class="bitian">(必填):</span></label>
                                                    {!! Form::text('price', null, ['class' => 'form-control', 'onkeyup' => 'this.value=this.value.replace(/[^\d.]/g,&quot;&quot;)', 'onpaste' => 'this.value=this.value.replace(/[^\d.]/g,&quot;&quot;)']) !!}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            {!! Form::label('intro', '产品详情') !!}
                                                {!! Form::textarea('intro', null, ['class' => 'form-control intro']) !!}
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="box box-primary mb10-xs">
                                    <div class="box-body">
                                        <label class="fb">
                                            {!! Form::checkbox('shelf', 1, null, ['class' => 'field minimal']) !!}上架
                                        </label>
                                    </div>
                                </div>
                                <div class="box box-primary">
                                    <div class="box-body">
                                        <!-- Submit Field -->
                                        <div class="form-group">
                                            {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
                                            <a href="{!! route('products.index') !!}" class="btn btn-default">取消</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- 开启分销，并且按产品提成时设置 -->
                                @if(funcOpen('FUNC_DISTRIBUTION') && getSettingValueByKey('distribution')=='是' && getSettingValueByKey('distribution_type')=='产品')
                                    <div class="box ">
                                        <div class="box-body">
                                            <!-- Submit Field -->
                                            <div class="form-group">
                                                {!! Form::label('commission', '佣金用于提成:') !!}
                                                {!! Form::text('commission', null, ['class' => 'form-control', 'onkeyup' => 'this.value=this.value.replace(/[^\d.]/g,&quot;&quot;)', 'onpaste' => 'this.value=this.value.replace(/[^\d.]/g,&quot;&quot;)']) !!}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="box box-primary mb10-xs">
                                    <div class="box-body">

                                        <div class="row">

                                            <div class="form-group col-xs-12 pr0-xs">
                                                {!! Form::label('sort', '排序权重:') !!}
                                                {!! Form::number('sort', null, ['class' => 'form-control', ]) !!}
                                                <p class="help-block">权重越高，排序越靠前</p>
                                            </div>
                                            <div class="form-group col-xs-12 pr0-xs">
                                                {!! Form::label('sales_count', '已售数量:') !!}
                                                {!! Form::text('sales_count', null, ['class' => 'form-control']) !!}
                                            </div>
                                           
                                        </div>

                                        <div class="row">
                                  
                                            <!--div class="form-group col-xs-6">
                                                {!! Form::label('keywords', '关键词') !!}
                                                    {!! Form::text('keywords', null, ['class' => 'form-control']) !!}
                                            </div-->
                                        </div>
                                        <div class="row">
                                          
                                            <!--div class="form-group col-xs-6">
                                                <label for="free_shipping" class="control-label">是否包邮</label>
                                                <div class="">
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="free_shipping" value=1 @if($product->
                                                            free_shipping == 1) checked="checked" @endif>
                                                          是
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="free_shipping" value=0 @if($product->
                                                            free_shipping == 0) checked="checked" @endif>
                                                          否
                                                        </label>
                                                    </div>
                                                </div>
                                            </div-->
                                            <div class="form-group col-xs-4">
                                                {!! Form::label('is_hot', '热销产品:') !!}
                                                    {!! Form::select('is_hot', [0 => '否', 1 => '是'], null , ['class' => 'form-control']) !!}
                                            </div>
                                            <div class="form-group col-xs-4">
                                                {!! Form::label('is_new', '新品上市:') !!}
                                                    {!! Form::select('is_new', [0 => '否', 1 => '是'], null , ['class' => 'form-control']) !!}
                                            </div>
                                        </div>

                            
                                    </div>
                                </div>

                                <div class="box box-primary visible-xs mb10-xs">
                                    <div class="box-body">
                                        <!-- Submit Field -->
                                        <div class="form-group">
                                            {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
                                            <a href="{!! route('products.index') !!}" class="btn btn-default">取消</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <!-- /.box-body --> </div>
            </div>

            <!-- /.tab-pane -->
            <div class="tab-pane {!! $edit_rember?'active':'' !!}" id="tab_2">
                <div class="box ">
                    <!-- form start -->
                    <div class="box-body">
                        <section class="content-header" style="height: 50px; padding: 0; padding-top: 15px;">
                            <input type="hidden" name="addimage" value="" id="product_image">
                            <input type="hidden" id="product_id" value="{{$product->id}}"></input>
                        <h1 class="pull-left" style="font-size: 14px; font-weight: bold; line-height: 34px;">展示图片</h1>
                        <h3 class="pull-right" style="margin: 0">
                            <div class="pull-right" style="margin: 0">
                                <a data-toggle="modal" href="javascript:;" data-target="#myModal" clproductimageass="btn btn-primary" type="button" onclick="productimage('product_image')">添加产品图片</a>
                            </div>
                        </h3>
                    </section>
                    <div class="images">
                        @foreach ($images as $image)
                        <div class="image-item" id="product_image_{{$image->
                            id}}">
                            <img src="{!! $image->
                            url !!}" alt="" style="max-width: 100%;">
                            <div class="tr">
                                <div class="btn btn-danger btn-xs" onclick="deletePic({{ $image->id }})">删除</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        <!-- /.tab-pane -->
    
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_4">
            <div class="box">
                <!-- form start -->
                <div class="box-body"></div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right" onclick="">保存</button>
                </div>
            </div>
        </div>
        <!-- /.tab-pane --> </div>
    <!-- /.tab-content -->
</div>
</div>
@include('admin.partials.imagemodel')
@include('admin.partials.imagemodel_product_spec')

@endsection

@section('scripts')
    @include('admin.products.partials.js')
{{--     @include('admin.products.partials.js_edit') --}}
@endsection
