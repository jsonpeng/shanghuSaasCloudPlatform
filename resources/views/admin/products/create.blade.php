@extends('admin.layouts.app_shop', ['index' => '001'])  

@include('admin.products.partials.css')

@section('content')
<section class="content-header pb15-xs" style="margin-bottom: 0;">
    <h1>添加产品</h1>
</section>
<div class="content container-fluid pdall0-xs">
    @include('adminlte-templates::common.errors')
        {!! Form::open(['route' => 'products.store']) !!}
    <div class="row">
        <div class="col-sm-8">
            <div class="box mb10-xs">
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
                            <img src="" style="max-width: 100%; max-height: 150px; display: block;"></div>
                    </div>

               

                    <div class="form-group">
                        {!! Form::label('category', '产品分类:') !!}
                        <div class="row">

                         
                            <div class="col-xs-4 col-sm-4 pr0-xs">
                                {!! Form::select('level01', $categories, null , ['class' => 'form-control level01']) !!}
                            </div>
                            
                 
                        </div>
                    </div>

                    <div class="form-group " style="overflow: hidden;">
                        <label for="services">选择服务<span class="bitian">(必选):</span></label>
                           <button class="btn btn-primary btn-sm daterange " type="button" title="选择服务" onclick="addServiceMenuFunc()"> <i class="fa fa-plus"></i>
                        </button>
                 {{--   @if(count($services))
                            <div class="row">
                                @foreach($services as $service)
                                    <div class="col-sm-3">
                                        <label>
                                            {!! Form::checkbox('services[]', $service->id, in_array($service->id, $selectedServices), ['class' => 'select_service']) !!}
                                                {!! $service->name !!}
                                        </label>
                                    </br>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <a href="{!! route('services.create') !!}">请先创建服务</a>
                        @endif --}}
                    </div>

                    <div id="services_items" class="form-group" style="display:{!! empty($product) ?'none':'block' !!};margin-top:20px;">
                            <div class="box-header with-border">
                                <h3 class="box-title">关联服务信息</h3>
                            </div>
                            <div  class="box-body" >
                                <div class="row" style="background-color: #edfbf8;">
                                    <div class="col-md-3 col-xs-3">服务名称</div>
                                    <div class="col-md-3 col-xs-3">服务数量(次)</div>
                                 {{--    <div class="col-md-4 col-xs-4">服务价格(元)</div> --}}
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

                                        {{--             <div class="col-md-4 col-xs-4" >
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
        <div class="col-sm-4 " style="background-color: #fff;">
            <div class="box mb10-xs">
                <div class="box-body">
                    <label class="fb">
                        {!! Form::checkbox('shelf', 1, true, ['class' => 'field minimal']) !!}上架
                    </label>
                </div>
            </div>

            <div class="box">
                <div class="box-body">
                    <!-- Submit Field -->
                    <div class="form-group">
                        {!! Form::submit('下一步', ['class' => 'btn btn-primary']) !!}
                        <a href="{!! route('products.index') !!}" class="btn btn-default">取消</a>
                    </div>
                </div>
            </div>
            
            <!-- 开启分销，并且按产品提成时设置 -->
            @if(funcOpen('FUNC_DISTRIBUTION') && getSettingValueByKey('distribution')=='是' && getSettingValueByKey('distribution_type')=='产品')
                <div class="box">
                    <div class="box-body">
                        <!-- Submit Field -->
                        <div class="form-group">
                            {!! Form::label('commission', '佣金用于提成:') !!}
                            {!! Form::text('commission', 0, ['class' => 'form-control', 'onkeyup' => 'this.value=this.value.replace(/[^\d.]/g,&quot;&quot;)', 'onpaste' => 'this.value=this.value.replace(/[^\d.]/g,&quot;&quot;)']) !!}
                        </div>
                    </div>
                </div>
            @endif

            

            <div class="box mb10-xs">
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-xs-12 pr0-xs">
                            {!! Form::label('sort', '排序权重:') !!}
                            {!! Form::number('sort', null, ['class' => 'form-control']) !!}
                            <p class="help-block">权重越高，排序越靠前</p>
                        </div>

                        
                        <div class="form-group col-xs-12 pr0-xs">
                            {!! Form::label('sales_count', '已售数量:') !!}
                            {!! Form::text('sales_count', 0, ['class' => 'form-control']) !!}
                        </div>
                  
                    </div>
              
           
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

        <div class="box visible-xs mb10-xs">
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
@include('admin.partials.imagemodel')
@endsection

@section('scripts')
    @include('admin.products.partials.js')
@endsection