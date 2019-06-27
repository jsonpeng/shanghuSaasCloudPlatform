<!-- Name Field -->
<div class="form-group col-sm-12 col-xs-12">
    {!! Form::label('name', '银行卡名称:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Img Field -->
<div class="form-group col-sm-12 col-xs-12">
    {!! Form::label('img', '图片:') !!}
       <div class="input-append">
        {!! Form::text('img', null, ['class' => 'form-control', 'id' => 'image1']) !!}
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image1')">选择图片</a>
        <img src="@if($bankSets) {{$bankSets->img}} @endif" style="max-width: 100%; max-height: 150px; display: block;">
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('bankSets.index') !!}" class="btn btn-default">返回</a>
</div>
