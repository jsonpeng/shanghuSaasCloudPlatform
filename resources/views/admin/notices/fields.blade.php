<!-- Name Field -->
<div class="form-group col-sm-12">
    <label for="name">标题<span class="bitian">(必填):</span></label>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Content Field -->
<div class="form-group col-sm-12 col-lg-12">
    <label for="name">通知内容<span class="bitian">(必填):</span></label>
    {!! Form::textarea('content', null, ['class' => 'form-control intro']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('notices.index') !!}" class="btn btn-default">取消</a>
</div>
