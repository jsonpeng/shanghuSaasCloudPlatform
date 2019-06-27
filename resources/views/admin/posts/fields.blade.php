<!-- Name Field -->
<div class="form-group col-sm-8">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">文章正文</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="form-group">
                 {!! Form::hidden('user_id', null) !!}
                 <label for="name">标题<span class="bitian">(必填):</span></label>
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>

       {{--      <div class="form-group">
                {!! Form::label('slug', '别名:') !!}
                {!! Form::text('slug', null, ['class' => 'form-control']) !!}
            </div> --}}

            <div class="form-group" style="overflow: hidden;">
                @foreach ($categories as $category)
                <div style="float: left; margin-right: 20px; ">
                    <label>
                        {!! Form::checkbox('categories[]', $category->id, in_array($category->id, $selectedCategories), ['class' => 'select_cat','data-slug'=>$category->slug]) !!}
                            {!! $category->name !!}
                    </label>
                </br>
            </div>
            @endforeach
        </div>
{{-- 
        <div class="form-group">
            {!! Form::label('brief', '简介:') !!}
                {!! Form::textarea('brief', null, ['class' => 'form-control']) !!}
        </div>
 --}}

        <div class="form-group">
                      <section class="content-header" style="height: 50px; padding: 0; padding-top: 15px;">
                      <h1 class="pull-left" style="font-size: 14px; font-weight: bold; line-height: 34px;padding-bottom: 0px;">展示图片</h1>

                       <h3 class="pull-right" style="margin: 0">
                                <div class="pull-right" style="margin: 0">
                                    <a  href="javascript:;"  class="btn btn-primary" type="button" id="uploads_image">添加展示图片</a>
                                </div>
                        </h3>
                    </section>

                    <div class="from-group images" id="success_image_box" style="display:@if(count($images)) flex @else none @endif;">
                          
                            @foreach ($images as $image)
                                <div class="dz-preview dz-file-preview uploads_box">
                                    <img class="success_img" src="{!! $image->url !!}"/>
                                    <input type="hidden" name="post_images[]" value="{!! $image->url !!}">
                                    <span class="dz-progress"></span>
                                    <div class="zhezhao" data-status="none" style="display: none;"></div>
                                    <a class="remove" href="javascript:;" onclick="remove(this)">删除</a>
                                </div>
                            @endforeach
                    </div>
        </div>

        <div class="form-group">
             <label for="name">正文<span class="bitian">(必填):</span></label>
                {!! Form::textarea('content', null, ['class' => 'form-control intro']) !!}
        </div>

    </div>
    <!-- /.box-body -->
</div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-4">

<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">发布设置</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="form-group">
            <label class="fb">
                {!! Form::checkbox('status', 1, null, ['class' => 'field minimal']) !!}发布
            </label>
        </div>
        {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('posts.index') !!}" class="btn btn-default">取消</a>
    </div>
    <!-- /.box-body -->
</div>

<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">其他设置</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="form-group">
            <label class="fb">
         {!! Form::checkbox('is_hot', 1, null, ['class' => 'field minimal']) !!}热门
            </label>
        </div>
        <div class="form-group">
            {!! Form::label('view', '浏览量:') !!}
                {!! Form::number('view', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('sort', '排序:') !!}
                {!! Form::number('sort', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <!-- /.box-body -->
</div>


<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">关联商品</h3>
        <p class="text-muted">关联商品会在话题下显示</p>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div id="product_items" class="col-sm-12" style="display:block;margin-top:20px;">
            <div class="box-header with-border">
                <h3 class="box-title">关联商品信息</h3>
                <div class="pull-right box-tools">
                    <button class="btn btn-primary btn-sm daterange pull-right" type="button" title="添加商品" onclick="addProductMenuFunc(4)"> <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>

    <div  class="box-body">

        <div class="row" style="background-color: #edfbf8;">
            <div class="col-md-4 col-xs-4">商品</div>
            <div class="col-md-4 col-xs-5">规格</div>
            <div class="col-md-2 col-xs-1">单价</div>
            <div class="col-md-2 col-xs-2">修改</div>
        </div>
        @if(!empty($post))
             @if(count($products)>0) 
                 @foreach($products as $item)
            
             
                    <div class="items row" id="item_row_{!! $item->
                        id !!}" style="border-bottom: 1px solid #f4f4f4" data-id="{!! $item->id !!}" data-keyid="{!! $item->id !!}_0">
                        <div id="item_form_{{ $item->
                            id }}">
                            <div class="col-md-4 col-xs-4">
                                <img src="{{ $item->pic }}" alt="">{{ $item->name }}</div>
                            <div class="col-md-4 col-xs-5">--</div>

                            <div class="col-md-2 col-xs-1" id="item_price_{{ $item->
                                id }}">
                                <span>{{ $item->price }}</span>
                                <!--  <input type="text" class="form-control input-sm" name="price" value="{{ $item->price }}" style="display: none;"> --></div>

                            <div class="col-md-2 col-xs-2">
                                <div class='btn-group' id="item_" style="padding: 8px;">
                                    <a href="javascript:;" class='btn btn-danger btn-xs' id="item_delete_{{ $item->
                                        id }}"  onclick="delItem(this,{{ $item->id }})"> <i class="glyphicon glyphicon-trash" title="确认"></i>
                                    </a>
                                </div>
                            </div>
                            <input type="hidden" name="product_spec[]" value="{{ $item->id }}_0" /></div>
                    </div>
              
                @endforeach
            @endif
        @endif
    </div>
</div>

<div id="product_items_table" style="display:none;"></div>
    </div>
    <!-- /.box-body -->
</div>

</div>