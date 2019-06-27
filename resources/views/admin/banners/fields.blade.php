
<!-- Link Field -->
<div class="form-group col-sm-12">
	<label for="name">名称<span class="bitian">(必填):</span></label>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Sort Field -->
<div class="form-group col-sm-12">
    {!! Form::label('slug', '别名:') !!}
    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
    <p class="help-block">首页横幅的别名必须为 index</p>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('banners.index') !!}" class="btn btn-default">取消</a>
</div>
