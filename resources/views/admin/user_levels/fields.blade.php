<!-- Name Field -->
<div class="form-group col-sm-12">
    <label for="name">等级名称<span class="bitian">(必填):</span></label>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>


<div class="form-group col-sm-12">
    <label for="growth">需要成长值<span class="bitian">(必填):</span></label>
    {!! Form::number('growth', null, ['class' => 'form-control']) !!}
</div>


<!-- Discount Field -->
<div class="form-group col-sm-12">
    <label for="name">折扣率<span class="bitian">(必填):</span></label>
    {!! Form::number('discount', null, ['class' => 'form-control']) !!}
     <p class="help-block">此会员等级购买产品后享受打折优惠，七五折就写75</p>
</div>

<!-- Discribe Field -->
<div class="form-group col-sm-12">
    {!! Form::label('discribe', '描述:') !!}
    {!! Form::text('discribe', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('custom_benefits', '自定义权益(商家自行根据描述给予权益):') !!}
    {!! Form::text('custom_benefits', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('userLevels.index') !!}" class="btn btn-default">取消</a>
</div>
