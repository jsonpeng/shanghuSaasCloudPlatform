<!-- Name Field -->
<div class="form-group col-sm-12">
    <label for="name">名称<span class="bitian">(必填):</span></label>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>



<!-- Image Field -->
<div class="form-group col-sm-12">
    {!! Form::label('image', '图像:') !!}

    <div class="input-append">
        {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button">选择图片</a>
        <img src="@if($category) {{$category->image}} @endif" style="max-width: 100%; max-height: 150px; display: block;">
    </div>
</div>

<!-- Sort Field -->
<div class="form-group col-sm-12">
    {!! Form::label('sort', '排序:') !!}
    {!! Form::number('sort', null, ['class' => 'form-control']) !!}
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('categories.index') !!}" class="btn btn-default">取消</a>
</div>
