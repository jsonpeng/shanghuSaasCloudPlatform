<!-- Name Field -->
<div class="form-group col-sm-12">
    <label for="name">名称<span class="bitian">(必填):</span></label>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('view', '浏览量:') !!}
    {!! Form::number('view', null, ['class' => 'form-control']) !!}
</div>

<!-- Slug Field -->
{{-- <div class="form-group col-sm-12">
    {!! Form::label('slug', '别名:') !!}
    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Content Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('content', '内容:') !!}
    {!! Form::textarea('content', null, ['class' => 'form-control']) !!}
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('singelPages.index') !!}" class="btn btn-default">返回</a>
</div>
