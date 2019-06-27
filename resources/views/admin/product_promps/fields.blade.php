<!-- Name Field -->
<div class="form-group col-sm-12">
    <label for="name">活动名称<span class="bitian">(必填):</span></label>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-12">
    {!! Form::label('type', '活动类型:') !!}
    {!! Form::select('type', [0 => '打折优惠', 1 => '减价优惠', 2 => '固定金额出售'], null , ['class' => 'form-control']) !!}
</div>

<!-- Value Field -->
<div class="form-group col-sm-12 changeText">
    {!! Form::label('value', '折扣') !!}
    <span class="bitian">(必填):</span>
    {!! Form::text('value', null, ['class' => 'form-control']) !!}
    <p class="help-block">请输入折扣(%)，85折就输入85， 7折就输入70</p>
</div>

<div class="form-group col-sm-6">
    <label for="name">开始时间<span class="bitian">(必填):</span></label>
    <div class='input-group date' id='datetimepicker_begin'>
        {!! Form::text('time_begin', null, ['class' => 'form-control']) !!}
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>

<div class="form-group col-sm-6">
    <label for="name">结束时间<span class="bitian">(必填):</span></label>
    <div class='input-group date' id='datetimepicker_end'>
        {!! Form::text('time_end', null, ['class' => 'form-control']) !!}
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>

<div class="form-group col-sm-12">
    <label for="name">活动图片<span class="bitian">(必填):</span></label>
    <div class="input-append">
        {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button">设置</a>
        <img src="@if(!empty($productPromp))
            {{$productPromp->
        image}}
        @endif" style="max-width: 100%; max-height: 150px; display: block;">
    </div>
</div>

<!-- Intro Field 
<div class="form-group col-sm-12 col-lg-12">
{!! Form::label('intro', '活动介绍:') !!}
    {!! Form::textarea('intro', null, ['class' => 'form-control']) !!}
</div>
-->
<div class="form-group col-sm-12">
    <label for="name">选择商品<span class="bitian">(必选):</span></label>
<button class="btn btn-primary btn-sm daterange" type="button" title="添加商品" onclick="addProductMenuFunc()"> <i class="fa fa-plus"></i>
</button>
</div>

<div id="product_items" class="col-sm-12" style=" display:{!! count($product)>
0 || count($spec)>0 ?'block':'none' !!};margin-top:20px;">
<div class="box-header with-border">
    <h3 class="box-title">关联商品信息</h3>

</div>
<div class="box-body">

    <div class="row" style="background-color: #edfbf8;">
        <div class="col-md-4 col-xs-4">商品</div>
        <div class="col-md-3 col-xs-5">规格</div>
        <div class="col-md-1 col-xs-1">单价</div>
        <div class="col-md-2 col-xs-2">修改</div>
    </div>
         @if(count($product)>0)  
             @foreach($product as $item)
                    <div class="items row" id="item_row_{!! $item->
                        id !!}" style="border-bottom: 1px solid #f4f4f4" data-id="{!! $item->id !!}" data-keyid="{!! $item->id !!}_0">
                        <div id="item_form_{{ $item->
                            id }}">
                            <div class="col-md-4 col-xs-4">
                                <img src="{{ $item->image }}" class="img-auto" alt="">{{ $item->name }}</div>
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
</div>
</div>

<div id="product_items_table" style="display:none;"></div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
{!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
<a href="{!! route('productPromps.index') !!}" class="btn btn-default">取消</a>
</div>