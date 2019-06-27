<!-- Custom Tabs -->
<div class="nav-tabs-custom col-sm-12" style="padding: 0;">

    <ul class="nav nav-tabs">
        <li @if($operation == 'create') class="active" @endif>
            <a href="#tab_1" data-toggle="tab">基础信息</a>
        </li>
        @if($operation == 'edit')
        <li @if($operation == 'edit') class="active" @endif>
            <a href="#tab_2" data-toggle="tab">商品规格</a>
        </li>
        @endif
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="tab_1">
            @if($operation == 'create')
                {!! Form::open(['route' => 'products.store']) !!}
            @else
                {!! Form::model($product, ['route' => ['products.update', $product->id], 'method' => 'patch']) !!}
            @endif
            <div class="col-sm-8">
                <!-- Name Field -->
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">产品详情</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('name', '产品名称:') !!}
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('remark', '产品卖点:') !!}
                            {!! Form::text('remark', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Intro Field -->
                        <div class="form-group">
                            {!! Form::label('intro', '产品介绍:') !!}
                            {!! Form::textarea('intro', null, ['class' => 'form-control intro']) !!}
                        </div>

                    </div>
                    <!-- /.box-body --> </div>
            </div>

            <div class="col-sm-4">
                <!-- Shelf Field -->
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">发布商品</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <label class="fb">
                            {!! Form::checkbox('shelf', 1, null, ['class' => 'field minimal']) !!}上架
                        </label>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        @if($operation == 'create')
                            {!! Form::submit('下一步', ['class' => 'btn btn-info']) !!}
                        @else
                            {!! Form::submit('保存', ['class' => 'btn btn-info']) !!}
                        @endif
                        <a href="{!! route('products.index') !!}" class="btn btn-default pull-right">取消</a>
                    </div>
                    <!-- /.box-footer --> </div>

                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">推荐商品</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <label class="fb">
                            {!! Form::checkbox('recommend', 1, null, ['class' => 'field minimal']) !!}推荐
                        </label>
                    </div>
                    <!-- /.box-body --> </div>

                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">产品分类</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        @foreach ($categories as $category)
                        <div class=" col-sm-4">
                            <label>
                                {!! Form::checkbox('categories[]', $category->id, in_array($category->id, $selectedCategories), ['class' => 'field minimal']) !!}
                                    {!! $category->name !!}
                            </label>
                        </br>
                    </div>
                    @endforeach
                </div>
                <!-- /.box-body --> </div>

            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">产品封面图片</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="input-append">
                        {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button">更改</a>
                        <img src="@if($product)
                                {{$product->
                        image}}
                            @endif" style="max-width: 100%; max-height: 150px; display: block;">
                    </div>
                </div>
                <!-- /.box-body --> </div>

            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">产品展示图片</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <div class="input-append">添加</div>
                </div>
                <!-- /.box-body --> </div>

            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">邮费</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    {!! Form::text('freight', null, ['class' => 'form-control']) !!}
                </div>
                <!-- /.box-body --> </div>

            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">展示排序（数值越小，越靠前）:</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    {!! Form::text('sort', null, ['class' => 'form-control']) !!}
                </div>
                <!-- /.box-body --> </div>

        </div>
        {!! Form::close() !!}
    </div>
    <!-- /.tab-pane -->
    <div class="tab-pane active" id="tab_2">
        <div class="box box-default">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <div class="col-md-12">
                        <section class="content-header" style="height: 50px; padding: 0; padding-top: 15px;">
                            <h1 class="pull-left" style="font-size: 14px; font-weight: bold; line-height: 34px;">商品规格</h1>
                            <h3 class="pull-right" style="margin: 0">
                                <div class="btn btn-primary pull-right" style="margin: 0" onclick="addItem()">添加规格</div>
                            </h3>
                        </section>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-1">图片</div>
                            <div class="col-md-1">价格</div>
                            <div class="col-md-1">成本</div>
                            <div class="col-md-1">规格</div>
                            <div class="col-md-1">库存</div>
                            <div class="col-md-1">警告库存</div>
                            <div class="col-md-1">促销</div>
                            <div class="col-md-1">促销价格</div>
                            <div class="col-md-3">
                                <div class="row row0">
                                    <div class="col-md-6">促销开始</div>
                                    <div class="col-md-6">促销结束</div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="row row0">
                                    <div class="col-md-6">操作</div>
                                </div>
                            </div>
                        </div>

                        <div id="dimension-contianer">
                            @foreach ($dimensions as $element)
                            <div class="row">
                                <form id="form_{{$element->
                                    id}}">
                                    <input type="hidden" name="product_id" value="{{$product->
                                    id}}" id="product_id">
                                    <div class="col-md-1">
                                        <img src="{!! $element->
                                        image !!}" style="max-width: 100%; max-height: 34px;">
                                        <input type="hidden" name="image" value="{{$element->
                                        image}}" id="image{{$element->id}}">
                                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="productimage('image{{$element->id}}')" style="display: none; padding: 0;">更改</a>
                                    </div>
                                    <div class="col-md-1">
                                        <input class="form-control" disabled type="text" name="price" value="{{$element->price}}"></div>
                                    <div class="col-md-1">
                                        <input class="form-control" disabled type="text" name="cost" value="{{$element->cost}}"></div>
                                    <div class="col-md-1">
                                        <input class="form-control" disabled type="text" name="unit" value="{{$element->unit}}"></div>
                                    <div class="col-md-1">
                                        <input class="form-control" disabled type="text" name="inventory" value="{{$element->inventory}}"></div>
                                    <div class="col-md-1">
                                        <input class="form-control" disabled type="text" name="warn_inventory" value="{{$element->warn_inventory}}"></div>
                                    <div class="col-md-1">
                                        <select name="onsale" class="form-control" disabled>
                                            <option value="0" @if($element->onsale == 0) @endif>否</option>
                                            <option value="1" @if($element->onsale == 1) selected @endif>是</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <input class="form-control" disabled type="text" name="sales_price" value="{{$element->sales_price}}"></div>
                                    <div class="col-md-3">
                                        <div class="row row0">
                                            <div class="col-md-6">
                                                <div class='input-group date datetimepicker_start'>
                                                    <input class="form-control form_datetime" type="text" disabled name="sales_start" value="{{$element->
                                                    sales_start}}">
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class='input-group date datetimepicker_end'>
                                                    <input class="form-control form_datetime" type="text" disabled name="sales_end" value="{{$element->
                                                    sales_end}}">
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="row row0">
                                            <div class="col-md-6">
                                                <div class='btn-group'>
                                                    <div class='btn btn-default btn-xs edit' title='编辑' onclick="beginEdit({{$element->
                                                        id}})"> <i class="glyphicon glyphicon-edit"></i>
                                                    </div>
                                                    <div class='btn btn-default btn-xs ok' title='保存' onclick="updateItem({{$element->
                                                        id}})" style="display: none;"> <i class="glyphicon glyphicon-ok"></i>
                                                    </div>
                                                    <div class='btn btn-default btn-xs' title='删除' onclick="deleteItem({{$element->
                                                        id}})">
                                                        <i class="glyphicon glyphicon-trash"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @endforeach
                        </div>

                        <!-- 添加规格 -->
                        <div class="row" id="addItem" style="margin-top: 10px; display: block;border-bottom: 1px solid #eee;padding-bottom: 10px; display: none;">
                            <form id="add_form">
                                <input type="hidden" name="product_id" value="{{$product->
                                id}}" id="product_id">
                                <input type="hidden" name="freight" value="{{$product->
                                freight}}">
                                <div class="col-md-1">
                                    <img src="" style="max-width: 100%; max-height: 34px;">
                                    <input type="hidden" name="image" value="" id="imagenew">
                                    <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="productimage('imagenew')">更改</a>
                                </div>
                                <div class="col-md-1">
                                    <input class="form-control" type="text" name="price" value="10000"></div>
                                <div class="col-md-1">
                                    <input class="form-control" type="text" name="cost" value="0"></div>
                                <div class="col-md-1">
                                    <input class="form-control" type="text" name="unit" value="个"></div>
                                <div class="col-md-1">
                                    <input class="form-control" type="text" name="inventory" value="1000000"></div>
                                <div class="col-md-1">
                                    <input class="form-control" type="text" name="warn_inventory" value="10"></div>
                                <div class="col-md-1">
                                    <select name="onsale" class="form-control">
                                        <option value="0">否</option>
                                        <option value="1">是</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <input class="form-control" type="text" name="sales_price" value=""></div>
                                <div class="col-md-3">
                                    <div class="row row0">
                                        <div class="col-md-6">
                                            <div class='input-group date datetimepicker_start' id=''>
                                                {!! Form::text('sales_start', null, ['class' => 'form-control']) !!}
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class='input-group date datetimepicker_end' id=''>
                                                {!! Form::text('sales_end', null, ['class' => 'form-control']) !!}
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="row row0">
                                        <div class="col-md-6">
                                            <div class='btn-group'>
                                                <div class='btn btn-default btn-xs add' title='保存' onclick="saveItem()">
                                                    <i class="glyphicon glyphicon-ok"></i>
                                                </div>
                                                <div class='btn btn-default btn-xs cancel' title='取消' onclick="cancel()">
                                                    <i class="glyphicon glyphicon-remove"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.tab-pane -->
</div>
<!-- /.tab-content -->
</div>
<!-- nav-tabs-custom -->