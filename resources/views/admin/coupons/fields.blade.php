<!-- Department Field -->
<div class="form-group col-sm-12">
    <label for="name">名称<span class="bitian">(必填):</span></label>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Base Field -->
<div class="form-group col-sm-12">
    {!! Form::label('max_count', '每人最多领取数量:') !!}
    <?php 
        $max_count = 0;
        if (!empty($coupon)) {
            $max_count = null;
        }
    ?>
    {!! Form::number('max_count', $max_count, ['class' => 'form-control', 'placeholder' => 0]) !!}
    <p class="help-block">0 则表示不限量</p>
</div>

<!-- Type Field -->
<div class="form-group col-sm-12">
    {!! Form::label('type', '优惠券类型:') !!}
    {!! Form::select('type', ['满减' => '满减', '打折' => '打折'], null , ['class' => 'form-control']) !!}
</div>

<!-- Base Field -->
<div class="form-group col-sm-12">
    {!! Form::label('base', '最低消费金额') !!}<span class="bitian">(必填):</span>
    {!! Form::number('base', null, ['class' => 'form-control', 'placeholder' => 0]) !!}
</div>

<!-- Given Field -->
<div class="form-group col-sm-12" @if (!empty($coupon) && $coupon->
    type == '打折') style="display: none;" @endif>
    {!! Form::label('given', '优惠金额:') !!}
    {!! Form::number('given', null, ['class' => 'form-control', 'placeholder' => 0]) !!}
    <p class="help-block">适用满减类型的优惠券</p>
</div>

<!-- Discount Field -->
<div class="form-group col-sm-12" @if (empty($coupon) || $coupon->
    type == '满减') style="display: none;" @endif>
    {!! Form::label('discount', '折扣:') !!}
    {!! Form::number('discount', null, ['class' => 'form-control', 'placeholder' => 100]) !!}
    <p class="help-block">适用打折类型的优惠券，七五折就写75</p>
</div>

<!-- Type Field -->
<div class="form-group col-sm-12">
    {!! Form::label('time_type', '有效期类型:') !!}
    {!! Form::select('time_type', [0 => '固定有效日期', 1 => '领券后一段时间内'], null , ['class' => 'form-control']) !!}
</div>

<!-- Discount Field -->
<div class="form-group col-sm-12" @if (empty($coupon) || $coupon->
    time_type == 0) style="display: none;" @endif>
    {!! Form::label('expire_days', '有效期天数:') !!}
    <?php 
        $expire_days = 30;
        if (!empty($coupon)) {
            $expire_days = null;
        }
    ?>
    {!! Form::number('expire_days', $expire_days, ['class' => 'form-control', 'placeholder' => 30]) !!}
    <p class="help-block">领券后开始计算，适合 领券后一段时间内 类型的有效期</p>
</div>

<div class="form-group col-sm-6" @if (!empty($coupon) && $coupon->
    time_type == 1) style="display: none;" @endif>
    {!! Form::label('time_begin', '有效期(起始):') !!}
    <div class='input-group date' id='datetimepicker_begin'>
        {!! Form::text('time_begin', null, ['class' => 'form-control', 'maxlength' => '10']) !!}
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>

<div class="form-group col-sm-6" @if (!empty($coupon) && $coupon->
    time_type == 1) style="display: none;" @endif>
    {!! Form::label('time_end', '有效期(结束):') !!}
    <div class='input-group date' id='datetimepicker_end'>
        {!! Form::text('time_end', null, ['class' => 'form-control', 'maxlength' => '10']) !!}
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>

<div class="form-group col-sm-12">
    {!! Form::label('range', '可使用商品:') !!}
    {!! Form::select('range', [0 => '全场通用', 1 => '指定分类', 2 => '指定商品'], null , ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12 category_select" @if (empty($coupon) || $coupon->
    range != 1) style="display: none;" @endif>
    {!! Form::label('category_id', '产品分类:') !!}
    <div class="row">
        <div class="col-sm-12 col-xs-12 pr0-xs">
            <?php $level1 = empty($level01) ? null : $level01; ?>
            {!! Form::select('level01', $categories, $level1  , ['class' => 'form-control level01']) !!}
        </div>
    </div>
</div>

<div id="product_items" class="col-sm-12" style="display:{!! empty($coupon) || $coupon->
    range != 2?'none':'block' !!};margin-top:20px;">
    <div class="box-header with-border">
        <h3 class="box-title">关联商品信息</h3>
        <div class="pull-right box-tools">
            <button class="btn btn-primary btn-sm daterange pull-right" type="button" title="添加商品" onclick="addProductMenuFunc(4)"> <i class="fa fa-plus"></i>
            </button>
        </div>
    </div>
    <div  class="box-body" >
        <div class="row" style="background-color: #edfbf8;">
            <div class="col-md-4 col-xs-4">商品</div>
            <div class="col-md-4 col-xs-5">规格</div>
            <div class="col-md-2 col-xs-1">单价</div>
            <div class="col-md-2 col-xs-2">修改</div>
        </div>
        @if (!empty($coupon))
        @if($coupon->range==2)

         @if(count($products)>0) 
         @foreach($products as $item)
            <div class="items row" id="item_row_{!! $item->
                id !!}" style="border-bottom: 1px solid #f4f4f4" data-id="{!! $item->id !!}" data-keyid="{{ $item->id }}_0">
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
        @endif
    </div>
</div>

<div id="product_items_table" style="display:none;"></div>

<!-- Submit Field -->
<div class="form-group col-sm-12" style="margin-top: 50px;">
    {!! Form::submit('保存', ['class' => 'btn btn-primary','type'=>'submit']) !!}
    <a href="{!! route('coupons.index') !!}" class="btn btn-default">取消</a>
</div>