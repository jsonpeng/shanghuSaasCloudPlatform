<!-- Id Field -->
<div class="form-group col-md-1">
    {!! Form::label('id', '编号:') !!}
    <p>{!! $coupon->id !!}</p>
</div>

<div class="form-group col-md-1">
    {!! Form::label('id', '名称:') !!}
    <p>{!! $coupon->name !!}</p>
</div>

<!-- Time End Field -->
<div class="form-group col-md-2">
    {!! Form::label('time_end', '有效期:') !!}
    <p>{!! $coupon->time_end !!}</p>
</div>

<!-- Type Field -->
<div class="form-group col-md-1">
    {!! Form::label('type', '类型:') !!}
    <p>{!! $coupon->type !!}</p>
</div>

<!-- Base Field -->
<div class="form-group col-md-1">
    {!! Form::label('base', '最低金额:') !!}
    <p>{!! $coupon->base !!}</p>
</div>

<!-- Given Field -->
<div class="form-group col-md-1">
    {!! Form::label('given', '优惠金额:') !!}
    <p>{!! $coupon->given !!}</p>
</div>

<!-- Discount Field -->
<div class="form-group col-md-1">
    {!! Form::label('discount', '折扣:') !!}
    <p>{!! $coupon->discount !!}</p>
</div>

<!-- Together Field -->
<div class="form-group col-md-1">
    {!! Form::label('together', '叠加使用:') !!}
    <p>{!! $coupon->together !!}</p>
</div>

<!-- Department Field -->
<div class="form-group col-md-1">
    {!! Form::label('department', '承担部门:') !!}
    <p>{!! $coupon->department !!}</p>
</div>


