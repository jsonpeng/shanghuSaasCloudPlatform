
<div class="form-group col-sm-12">
    <label for="name">图像<span class="bitian">(必填):</span></label>
    <div class="input-append">
        {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button">选择图片</a>
        <img src="@isset($bannerItem) {{$bannerItem->image}} @endisset" style="max-width: 100%; max-height: 150px; display: block;">
    </div>

</div>

<!-- Link Field -->
<div class="form-group col-sm-12">
    {!! Form::label('link', '链接:') !!}
    {!! Form::text('link', null, ['class' => 'form-control']) !!}
</div>

<!-- Sort Field -->
<div class="form-group col-sm-12">
    {!! Form::label('sort', '排序(数值越大，权重越大，排序越靠前):') !!}
    {!! Form::number('sort', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('bannerItems.index', $banner_id) !!}" class="btn btn-default">取消</a>
</div>
