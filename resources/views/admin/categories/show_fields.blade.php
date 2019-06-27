<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', '编号:') !!}
    <p>{!! $category->id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', '名称:') !!}
    <p>{!! $category->name !!}</p>
</div>

<!-- Intro Field -->
<div class="form-group">
    {!! Form::label('intro', '介绍:') !!}
    <p>{!! $category->intro !!}</p>
</div>

<!-- Sort Field -->
<div class="form-group">
    {!! Form::label('sort', '排序:') !!}
    <p>{!! $category->sort !!}</p>
</div>

<!-- Image Field -->
<div class="form-group">
    {!! Form::label('image', '图片:') !!}
    <img src="{!! $category->image !!}" style="display: block; max-height: 150px; max-width: 100%;">
    <p></p>
</div>

<div class="form-group">
    {!! Form::label('recommend', '推荐:') !!}
    <p>{!! $category->isRecommend !!}</p>
</div>

<div class="form-group">
    {!! Form::label('recommend_title', '推荐标题:') !!}
    <p>{!! $category->recommend_title !!}</p>
</div>

<div class="form-group">
    {!! Form::label('recommend_des', '推荐描述:') !!}
    <p>{!! $category->recommend_des !!}</p>
</div>

<!-- Parent Id Field -->
<div class="form-group">
    {!! Form::label('parent_id', '上级分类:') !!}
    <p>{!! $category->parent !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', '创建日期:') !!}
    <p>{!! $category->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', '更新日期:') !!}
    <p>{!! $category->updated_at !!}</p>
</div>

