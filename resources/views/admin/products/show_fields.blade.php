<div class="box box-primary">
    <div class="box-body">
        <div class="row" style="padding-left: 20px">
            <div class="form-group col-md-1">
                {!! Form::label('image', '图片:') !!}
                <img src="{!! $product->image !!}" style="display: block; max-height: 150px; max-width: 100%;">
                <p></p>
            </div>

            <!-- Name Field -->
            <div class="form-group col-md-1">
                {!! Form::label('name', '名称:') !!}
                <p>{!! $product->name !!}</p>
            </div>

            <!-- Shelf Field -->
            <div class="form-group col-md-1">
                {!! Form::label('shelf', '是否上架:') !!}
                <p>{!! $product->isShelf !!}</p>
            </div>

            <!-- Shelf Field -->
            <div class="form-group col-md-1">
                {!! Form::label('shelf', '是否推荐:') !!}
                <p>{!! $product->isRecommend !!}</p>
            </div>

            <!-- Category Id Field -->
            <div class="form-group col-md-1">
                {!! Form::label('category_id', '类别:') !!}
                <p>{!! $product->category !!}</p>
            </div>

            <div class="form-group col-md-1">
                {!! Form::label('category_id', '邮费:') !!}
                <p>{!! $product->freight !!}</p>
            </div>

            <div class="form-group col-md-3">
                {!! Form::label('category_id', '备注:') !!}
                <p>{!! $product->remark !!}</p>
            </div>

            <!-- Created At Field -->
            <div class="form-group col-md-2">
                {!! Form::label('created_at', '上货日期:') !!}
                <p>{!! $product->created_at !!}</p>
            </div>

            <!-- Updated At Field -->
            <div class="form-group col-md-2">
                {!! Form::label('updated_at', '更新日期:') !!}
                <p>{!! $product->updated_at !!}</p>
            </div>
        </div>
    </div>
</div>


<style type="text/css">
    input{width: 80%;}
    .p0{padding: 0;}
    .col-md-1{padding: 0 2px;}
    .col-md-6{padding: 0 2px;}
    .col-md-3{padding: 0 2px;}
    .row0{margin: 0;}
    #addItem{display: none;}
    #dimension-contianer .row, #para-contianer .row{
        display: block; padding-bottom: 10px;
    }
</style>

<div class="box box-primary">
    <div class="box-body">
        <div class="row" style="padding-left: 20px">
            <div class="col-md-12">
                <section class="content-header" style="height: 50px; padding: 0; padding-top: 15px;">
                    <input type="hidden" name="addimage" value="" id="product_image"> 
                    <h1 class="pull-left" style="font-size: 14px; font-weight: bold; line-height: 34px;">展示图片</h1>
                    <h3 class="pull-right" style="margin: 0">
                       <div class="pull-right" style="margin: 0"><a data-toggle="modal" href="javascript:;" data-target="#myModal2" class="btn btn-primary" type="button">添加商品图片</a></div>
                    </h3>
                </section>
                <div class="images">
                @foreach ($images as $image)
                    <div class="image-item" id="product_image_{{$image->id}}">
                        <img src="{!! $image->url !!}" alt="" style="max-width: 100%;">
                        <div class="tr"><div class="btn btn-danger btn-xs" onclick="deletePic({{ $image->id }})">删除</div></div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary">
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
                        <form id="form_{{$element->id}}">
                            <input type="hidden" name="product_id" value="{{$product->id}}" id="product_id">
                            <div class="col-md-1">
                                <img src="{!! $element->image !!}" style="max-width: 100%; max-height: 34px;"><input type="hidden" name="image" value="{{$element->image}}" id="image{{$element->id}}"> <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="productimage('image{{$element->id}}')" style="display: none; padding: 0;">更改</a>
                            </div>
                            <div class="col-md-1"><input class="form-control" disabled type="text" name="price" value="{{$element->price}}"></div>
                            <div class="col-md-1"><input class="form-control" disabled type="text" name="cost" value="{{$element->cost}}"></div>
                            <div class="col-md-1"><input class="form-control" disabled type="text" name="unit" value="{{$element->unit}}"></div>
                            <div class="col-md-1"><input class="form-control" disabled type="text" name="inventory" value="{{$element->inventory}}"></div>
                            <div class="col-md-1"><input class="form-control" disabled type="text" name="warn_inventory" value="{{$element->warn_inventory}}"></div>
                            <div class="col-md-1">
                                <select name="onsale" class="form-control" disabled>
                                    <option value="0" @if($element->onsale == 0) @endif>否</option>
                                    <option value="1" @if($element->onsale == 1) selected @endif>是</option>
                                </select> 
                            </div>
                            <div class="col-md-1"><input class="form-control" disabled type="text" name="sales_price" value="{{$element->sales_price}}"></div>
                            <div class="col-md-3">
                                <div class="row row0">
                                    <div class="col-md-6">
                                        <div class='input-group date datetimepicker_start'>
                                            <input class="form-control form_datetime" type="text" disabled name="sales_start" value="{{$element->sales_start}}">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class='input-group date datetimepicker_end'>
                                            <input class="form-control form_datetime" type="text" disabled name="sales_end" value="{{$element->sales_end}}">
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
                                            <div class='btn btn-default btn-xs edit' title='编辑' onclick="beginEdit({{$element->id}})"><i class="glyphicon glyphicon-edit"></i></div>
                                            <div class='btn btn-default btn-xs ok' title='保存' onclick="updateItem({{$element->id}})" style="display: none;"><i class="glyphicon glyphicon-ok"></i></div>
                                            <div class='btn btn-default btn-xs' title='删除' onclick="deleteItem({{$element->id}})"><i class="glyphicon glyphicon-trash"></i></div>
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
                        <input type="hidden" name="product_id" value="{{$product->id}}" id="product_id">
                        <input type="hidden" name="freight" value="{{$product->freight}}">
                        <div class="col-md-1">
                            <img src="" style="max-width: 100%; max-height: 34px;"><input type="hidden" name="image" value="" id="imagenew"> <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="productimage('imagenew')">更改</a>
                        </div>
                        <div class="col-md-1"><input class="form-control" type="text" name="price" value="10000"></div>
                        <div class="col-md-1"><input class="form-control" type="text" name="cost" value="0"></div>
                        <div class="col-md-1"><input class="form-control" type="text" name="unit" value="个"></div>
                        <div class="col-md-1"><input class="form-control" type="text" name="inventory" value="1000000"></div>
                        <div class="col-md-1"><input class="form-control" type="text" name="warn_inventory" value="10"></div>
                        <div class="col-md-1">
                            <select name="onsale" class="form-control">
                                <option value="0" @if($element->onsale == 0) @endif>否</option>
                                <option value="1" @if($element->onsale == 1) @endif>是</option>
                            </select> 
                        </div>
                        <div class="col-md-1"><input class="form-control" type="text" name="sales_price" value=""></div>
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
                                        <div class='btn btn-default btn-xs add' title='保存' onclick="saveItem()"><i class="glyphicon glyphicon-ok"></i></div>
                                        <div class='btn btn-default btn-xs cancel' title='取消' onclick="cancel()"><i class="glyphicon glyphicon-remove"></i></div>
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

<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <!-- Intro Field -->
                    <div class='form-group col-md-12' style="margin-top: 20px;">
                        {!! Form::label('intro', '产品介绍:') !!}
                        <p>{!! $product->intro !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <div class="col-md-12">
                        <section class="content-header" style="height: 50px; padding: 0; padding-top: 15px;">
                            <h1 class="pull-left" style="font-size: 14px; font-weight: bold; line-height: 34px;">商品参数</h1>
                            <h3 class="pull-right" style="margin: 0">
                               <div class="btn btn-primary pull-right" style="margin: 0" onclick="addParaItem()">添加参数</div>
                            </h3>
                        </section>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">参数名称</div>
                                <div class="col-md-6">参数信息</div>
                                <div class="col-md-2">操作</div>
                            </div>
                            <div id="para-contianer">
                                @foreach ($paras as $element)
                                <div class="row">
                                    <form id="form_para_{{$element->id}}">
                                        <input type="hidden" name="product_id" value="{{$product->id}}" id="product_id">
                                        <div class="col-md-4"><input class="form-control" disabled type="text" name="name" value="{{$element->name}}"></div>
                                        <div class="col-md-6"><input class="form-control" disabled type="text" name="para" value="{{$element->para}}"></div>
                                        <div class="col-md-2">
                                            <div class='btn-group'>
                                            <div class='btn btn-default btn-xs edit' title='编辑' onclick="beginParaEdit({{$element->id}})"><i class="glyphicon glyphicon-edit"></i></div>
                                            <div class='btn btn-default btn-xs ok' title='保存' onclick="updateParaItem({{$element->id}})" style="display: none;"><i class="glyphicon glyphicon-ok"></i></div>
                                            <div class='btn btn-default btn-xs' title='删除' onclick="deleteParaItem({{$element->id}})"><i class="glyphicon glyphicon-trash"></i></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                @endforeach
                            </div>
                            <!-- 添加规格 -->
                            <div class="row" id="addParaItem" style="margin-top: 10px; display: block;border-bottom: 1px solid #eee;padding-bottom: 10px; display: none;">
                                <form id="add_para_form">
                                    <div class="col-md-4"><input class="form-control" type="text" name="name" value=""></div>
                                    <div class="col-md-6"><input class="form-control" type="text" name="para" value=""></div>
                                    <div class="col-md-2">
                                        <div class='btn-group'>
                                            <div class='btn btn-default btn-xs add' title='保存' onclick="saveParaItem()"><i class="glyphicon glyphicon-ok"></i></div>
                                            <div class='btn btn-default btn-xs cancel' title='取消' onclick="cancelPara()"><i class="glyphicon glyphicon-remove"></i></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





@include('admin.partials.imagemodel')

<script type="text/javascript">

    //动态改变图片的目标
    function productimage(id) {
        $('iframe#image').attr( 'src', '/filemanager/dialog.php?type=1&field_id=' + id);
    }

    function addItem(){
        $('#addItem').toggle();
    }
    //更新文字分类信息
    function updateItem(id){
        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"/zcjy/dimensions/" + id,
            type:"POST",
            data:$('#form_'+id).serialize()+'&_method=PATCH',
            success: function(data) {
                //提示成功消息
                console.log(data);
                $('#form_'+id+ ' .edit').show();
                $('#form_'+id+ ' .ok').hide();
                $('#form_'+id+ ' a').hide();
                $('#form_'+id+ ' input').attr('disabled', true);
                $('#form_'+id+ ' select').attr('disabled', true);
                $('#form_'+id+ ' img').attr('src', data.image);
                
            },
            error: function(data) {
                //提示失败消息

            },
        });
    };
    //开始编辑
    function beginEdit(id){
        $('#form_'+id+ ' input').removeAttr('disabled');
        $('#form_'+id+ ' select').removeAttr('disabled');
        $('#form_'+id+ ' a').show();
        $('#form_'+id+ ' .edit').hide();
        $('#form_'+id+ ' .ok').show();
    }

    //删除
    function deleteItem (id){
        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"/zcjy/dimensions/" + id,
            type:"POST",
            data:$('#form_'+id).serialize()+'&_method=DELETE',
            success: function(data) {
                //提示成功消息
                $('#form_'+id).parent().remove();
            },
            error: function(data) {
                //提示失败消息
            },
        });
    }

    //取消
    function cancel (){
        event.preventDefault();
        $('#addItem').toggle();
    }

    //保存
    function saveItem(){
        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"/zcjy/dimensions",
            type:"POST",
            data:$('#add_form').serialize(),
            success: function(data) {
                //提示成功消息
                var onsale = '';
                if (data.onsale == 1) {
                    onsale = ' selected';
                }
                console.log(data);
                $('#addItem').toggle();
                $('#dimension-contianer').append(
                    "<div class='row'>\
                    <form id='form_"+data.id+"'>\
                        <input type='hidden' name='product_id' value=" + data.product_id + ">\
                        <input type='hidden' name='_method' value='PATCH'>\
                        <div class='col-md-1'>\
                            <img src='"+data.image+"' style='max-width: 100%; max-height: 34px;'>\
                            <input type='hidden' name='image' value='" + data.image + "' id='image"+data.id+"'>\
                            <a data-toggle='modal' href='javascript:;' data-target='#myModal' class='btn' type='button' onclick='productimage('image" + data.id + "')' style='display: none;'>更改</a>\
                        </div>\
                        <div class='col-md-1'><input class='form-control' disabled type='text' name='price' value='" + data.price + "'></div>\
                        <div class='col-md-1'><input class='form-control' disabled type='text' name='cost' value='" + data.cost + "'></div>\
                        <div class='col-md-1'><input class='form-control' disabled type='text' name='unit' value='" + data.unit + "'></div>\
                        <div class='col-md-1'><input class='form-control' disabled type='number' name='inventory' value='" + data.inventory + "'></div>\
                        <div class='col-md-1'><input class='form-control' disabled type='number' name='warn_inventory' value='" + data.warn_inventory + "'></div>\
                        <div class='col-md-1'>\
                            <select name='onsale' class='form-control' disabled value='1'>\
                                <option value='0'>否</option>\
                                <option value='1' " + onsale + ">是</option>\
                            </select> \
                        </div>\
                        <div class='col-md-1'><input class='form-control' disabled type='text' name='sales_price' value='" + data.sales_price + "'></div>\
                        <div class='col-md-3'>\
                            <div class='row row0'>\
                                <div class='col-md-6'>\
                                    <div class='input-group date datetimepicker_start'>\
                                        <input class='form-control form_datetime' type='text' disabled name='sales_start' value='" + data.sales_start + "'>\
                                        <span class='input-group-addon'>\
                                            <span class='glyphicon glyphicon-calendar'></span>\
                                        </span>\
                                    </div>\
                                </div>\
                                <div class='col-md-6'>\
                                    <div class='input-group date datetimepicker_end'>\
                                        <input class='form-control form_datetime' type='text' disabled name='sales_end' value='" + data.sales_end + "'>\
                                        <span class='input-group-addon'>\
                                            <span class='glyphicon glyphicon-calendar'></span>\
                                        </span>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>\
                        <div class='col-md-1'>\
                            <div class='row row0'>\
                                <div class='col-md-6'>\
                                    <div class='btn-group'>\
                                        <div class='btn btn-default btn-xs edit' title='编辑' onclick='beginEdit(" + data.id + ")'><i class='glyphicon glyphicon-edit'></i></div>\
                                        <div class='btn btn-default btn-xs ok' title='保存' onclick='updateItem(" + data.id + ")' style='display: none;'><i class='glyphicon glyphicon-ok'></i></div>\
                                        <div class='btn btn-default btn-xs' title='删除' onclick='deleteItem(" + data.id + ")'><i class='glyphicon glyphicon-trash'></i></div>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>\
                    </form>\
                </div>"
                );
                $('.datetimepicker_start').datetimepicker({
                    format: 'yyyy-mm-dd hh:ii',
                    language: 'zh_CN'

                });
                $('.datetimepicker_end').datetimepicker({
                    format: 'yyyy-mm-dd hh:ii'
                });
            },
            error: function(data) {
                //提示失败消息

            },
        });
    }


    function addParaItem(){
        $('#addParaItem').toggle();
        $('#addParaItem input').val('');
    }
    //更新文字分类信息
    function updateParaItem(id){
        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"/zcjy/paras/" + id,
            type:"POST",
            data:$('#form_para_'+id).serialize()+'&_method=PATCH',
            success: function(data) {
                //提示成功消息
                console.log(data);
                $('#form_para_'+id+ ' .edit').show();
                $('#form_para_'+id+ ' .ok').hide();
                $('#form_para_'+id+ ' a').hide();
                $('#form_para_'+id+ ' input').attr('disabled', true);
                $('#form_para_'+id+ ' select').attr('disabled', true);
                
            },
            error: function(data) {
                //提示失败消息

            },
        });
    };
    //开始编辑
    function beginParaEdit(id){
        $('#form_para_'+id+ ' input').removeAttr('disabled');
        $('#form_para_'+id+ ' a').show();
        $('#form_para_'+id+ ' .edit').hide();
        $('#form_para_'+id+ ' .ok').show();
    }

    //删除
    function deleteParaItem (id){
        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"/zcjy/paras/" + id,
            type:"POST",
            data:$('#form_para_'+id).serialize()+'&_method=DELETE',
            success: function(data) {
                //提示成功消息
                $('#form_para_'+id).parent().remove();
            },
            error: function(data) {
                //提示失败消息
            },
        });
    }

    //取消
    function cancelPara (){
        event.preventDefault();
        $('#addParaItem').toggle();
    }

    //保存
    function saveParaItem(){
        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"/zcjy/paras",
            type:"POST",
            data:$('#add_para_form').serialize()+'&product_id='+$('#product_id').val(),
            success: function(data) {
                //提示成功消息
                console.log(data);
                $('#addParaItem').toggle();
                $('#para-contianer').append(
                    "<div class='row'>\
                    <form id='form_para_"+data.id+"'>\
                        <input type='hidden' name='product_id' value=" + data.product_id + ">\
                        <input type='hidden' name='_method' value='PATCH'>\
                        <div class='col-md-4'><input class='form-control' disabled type='text' name='name' value='" + data.name + "'></div>\
                        <div class='col-md-6'><input class='form-control' disabled type='text' name='para' value='" + data.para + "'></div>\
                        <div class='col-md-2'>\
                            <div class='btn-group'>\
                            <div class='btn btn-default btn-xs edit' title='编辑' onclick='beginParaEdit(" + data.id + ")'><i class='glyphicon glyphicon-edit'></i></div>\
                            <div class='btn btn-default btn-xs ok' title='保存' onclick='updateParaItem(" + data.id + ")' style='display: none;'><i class='glyphicon glyphicon-ok'></i></div>\
                            <div class='btn btn-default btn-xs' title='删除' onclick='deleteParaItem(" + data.id + ")'><i class='glyphicon glyphicon-trash'></i></div>\
                            </div>\
                        </div>\
                    </form>\
                </div>"
                );
            },
            error: function(data) {
                //提示失败消息

            },
        });
    }

    function deletePic(id){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"/zcjy/productImages/" + id,
            type:"POST",
            data:'_method=DELETE',
            success: function(data) {
                //提示成功消息
                console.log(data);
                if (data.code == 0) {
                    console.log('yes');
                    $('#product_image_' + id).remove();
                }
            },
            error: function(data) {
                //提示失败消息

            },
        });
    }
</script>