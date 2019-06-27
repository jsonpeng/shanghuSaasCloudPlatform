<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::text('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Orgin Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('orgin_price', 'Orgin Price:') !!}
    {!! Form::text('orgin_price', null, ['class' => 'form-control']) !!}
</div>

<!-- No Discount Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('no_discount_price', 'No Discount Price:') !!}
    {!! Form::text('no_discount_price', null, ['class' => 'form-control']) !!}
</div>

<!-- Use User Money Field -->
<div class="form-group col-sm-6">
    {!! Form::label('use_user_money', 'Use User Money:') !!}
    {!! Form::text('use_user_money', null, ['class' => 'form-control']) !!}
</div>

<!-- User Level Money Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_level_money', 'User Level Money:') !!}
    {!! Form::text('user_level_money', null, ['class' => 'form-control']) !!}
</div>

<!-- Coupon Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('coupon_id', 'Coupon Id:') !!}
    {!! Form::text('coupon_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Coupon Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('coupon_price', 'Coupon Price:') !!}
    {!! Form::text('coupon_price', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('discountOrders.index') !!}" class="btn btn-default">Cancel</a>
</div>
