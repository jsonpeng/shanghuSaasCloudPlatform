<!-- Name Field -->
<div class="form-group col-sm-12">
    <label for="nickname">名称<span class="bitian">(必填):</span></label>
    {!! Form::text('nickname', null, ['class' => 'form-control']) !!}
</div>



<!-- email Field -->
<div class="form-group col-sm-12">
    <label for="mobile">手机号<span class="bitian">(必填):</span></label>
    {!! Form::text('mobile', null, ['class' => 'form-control']) !!}
</div>

<!-- password Field -->

<div class="form-group col-sm-12">
    <label for="password">密码<span class="bitian">(必填):</span></label>
    {!! Form::text('password', '', ['class' => 'form-control']) !!}
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('shopManagers.index') !!}" class="btn btn-default">取消</a>
</div>
