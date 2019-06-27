<!-- Type Field -->
<div class="form-group col-sm-12">
    {!! Form::label('type', '规则类型:') !!}
    {!! Form::select('type', [0 => '新用户注册', 1 => '购物满送', 2 => '推荐新用户注册', 3 => '推荐新用户下单', 4 => '免费领取'], null , ['class' => 'form-control' ]) !!}
    <p class="help-block">免费领取是指用户在商城手动领取</p>
</div>

<!-- Base Field -->
<div class="form-group col-sm-12" @if (empty($couponRule) || $couponRule->type != 1) style="display: none;" @endif>
    {!! Form::label('base', '消费金额:') !!}
    <?php 
        $base = 0;
        if (!empty($couponRule)) {
            $base = null;
        }
    ?>
    {!! Form::number('base', $base, ['class' => 'form-control']) !!}
    <p class="help-block">购物满送 需要设置该金额</p>
</div>

<!-- Base Field -->
<div class="form-group col-sm-12">
    {!! Form::label('max_count', '发放数量:') !!}
    {!! Form::number('max_count', null, ['class' => 'form-control', 'placeholder' => '0']) !!}
    <p class="help-block">0 则表示不限量</p>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('time_begin', '规则生效时间:') !!}
    <div class='input-group date' id='datetimepicker_begin'>
        {!! Form::text('time_begin', null, ['class' => 'form-control', 'maxlength' => '10']) !!}
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('time_end', '规则结束时间:') !!}
    <div class='input-group date' id='datetimepicker_end'>
        {!! Form::text('time_end', null, ['class' => 'form-control', 'maxlength' => '10']) !!}
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>

<div class="form-group col-sm-12"> {!! Form::label('coupons', '赠送的购物券:') !!} </div>
<div class="form-group col-sm-12">
    @foreach ($coupons as $coupon)
            <label style="display: inline-block; margin-right: 15px;">
                {!! Form::checkbox('coupons[]', $coupon->id, in_array($coupon->id, $selectedCoupons), ['class' => 'field minimal']) !!}
                {!! $coupon->name !!}
            </label>
    @endforeach
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12" style="margin-top: 50px;">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('couponRules.index') !!}" class="btn btn-default">返回</a>
</div>
