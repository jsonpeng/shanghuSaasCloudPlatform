<!-- Name Field -->
{{-- <div class="form-group col-sm-12 col-xs-12">
    {!! Form::label('name', '活动名称:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div> --}}

<div class="form-group col-sm-12 col-xs-12">
     <label for="name">选择产品<span class="bitian">(必选):</span></label>
     {!! Form::text('product_name', null, ['class' => 'form-control']) !!}
    <button class="btn btn-primary btn-sm daterange" type="button" title="添加产品" onclick="addProductMenuFunc(1)" style="margin-top:15px;"> <i class="fa fa-plus"></i>
    </button>
    {!! Form::hidden('product_spec', $product_spec, ['class' => 'form-control']) !!}
     {!! Form::hidden('name','null', ['class' => 'form-control']) !!}
    <div id="seleted_one_goods">
        @if(!empty($product_spec))
            <div style="float: left;margin: 10px auto;" class="selected-group-goods">
                <div class="goods-thumb">
                    <img style="width: 162px;height: 162px" src="{!! $product->image !!}"></div>
                <div class="goods-name">
                    <a target="_blank" href="">{!! $product->name !!}</a>
                </div>
                <div class="goods-price">商城价：￥{!! $product->price !!}</div>
            </div>
        @endif
    </div>
</div>

<!-- Price Field -->
<div class="form-group col-sm-12 col-xs-12">
    <label for="name">秒杀价格<span class="bitian">(必填):</span></label>
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Product Num Field -->
<div class="form-group col-sm-12 col-xs-12">
    <label for="name">参与数量<span class="bitian">(必填):</span></label>
    {!! Form::number('product_num', null, ['class' => 'form-control']) !!}
</div>

<!-- Buy Limit Field -->
<div class="form-group col-sm-12 col-xs-12">
    <label for="name">单次最多购买数量<span class="bitian">(必填):</span></label>
    {!! Form::number('buy_limit', null, ['class' => 'form-control']) !!}
</div>

<!-- Intro Field 
<div class="form-group col-sm-12 col-xs-12 col-lg-12">
{!! Form::label('intro', 'Intro:') !!}
    {!! Form::textarea('intro', null, ['class' => 'form-control']) !!}
</div>
-->
<div class="form-group col-sm-6 col-xs-12">
 <label for="name">开始时间<span class="bitian">(必填):</span></label>
<div class='input-group date' id='datetimepicker_begin'>
    {!! Form::text('time_begin', null, ['class' => 'form-control']) !!}
    <span class="input-group-addon">
        <span class="glyphicon glyphicon-calendar"></span>
    </span>
</div>
</div>

<div class="form-group col-sm-6 col-xs-12">
 <label for="name">结束时间<span class="bitian">(必填):</span></label>
<div class='input-group date' id='datetimepicker_end'>
    {!! Form::text('time_end', null, ['class' => 'form-control']) !!}
    <span class="input-group-addon">
        <span class="glyphicon glyphicon-calendar"></span>
    </span>
</div>
</div>

<!-- Is End Field 
<div class="form-group col-sm-12 col-xs-12">
{!! Form::label('is_end', 'Is End:') !!}
    {!! Form::number('is_end', null, ['class' => 'form-control']) !!}
</div>
-->
<div id="product_items_table" style="display:none;"></div>

<!-- Submit Field -->
<div class="form-group col-sm-12 col-xs-12">
{!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
<a href="{!! route('flashSales.index') !!}" class="btn btn-default">取消</a>
</div>