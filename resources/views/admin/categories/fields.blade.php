<!-- Name Field -->
<div class="form-group col-sm-12">
   
    <label for="name">名称<span class="bitian">(必填):</span></label>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('slug', '别名:') !!}
    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('status', '状态:') !!}
    <select name="status" class="form-control">
        <option value="上线" @if(!empty($category) && $category->status=='上线') selected="selected" @endif>上线</option>
        <option value="下架" @if(!empty($category) && $category->status=='下架') selected="selected" @endif>下架</option>
    </select>
</div>


<div class="form-group col-sm-12">
    {!! Form::label('brief', '简介:') !!}
    {!! Form::text('brief', null, ['class' => 'form-control']) !!}
</div>

<!-- Sort Field -->
<div class="form-group col-sm-12">
    {!! Form::label('sort', '排序:') !!}
    <?php 
        $sort = 0;
        if (!empty($category)) {
            $sort = null;
        }
    ?>
    {!! Form::number('sort', $sort, ['class' => 'form-control']) !!}
</div>

@if (getSettingValueByKeyCache('category_level') > 1)
    <!-- Parent Id Field -->
    <div class="form-group col-sm-12">
        {!! Form::label('level01', '上级分类:') !!}
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                {!! Form::select('level01', $categories, $level01 , ['class' => 'form-control level01']) !!}
            </div>
            @if (getSettingValueByKeyCache('category_level') > 2)
                <div class="col-sm-6 col-xs-6">
                    {!! Form::select('level02', $second_categories, $level02 , ['class' => 'form-control level02']) !!}
                </div>
            @endif
        </div>
    </div>
@endif


<!-- Image Field -->
<div class="form-group col-sm-12">
    {!! Form::label('image', '图片:') !!}
    <div class="input-append">
        <!--input id="fieldID4" type="text" value=""-->
        {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button">更改</a>
        <img src="@if($category)
            {{$category->image}}
        @endif" style="max-width: 100%; max-height: 150px; display: block;">
    </div>
</div>



<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('categories.index') !!}" class="btn btn-default">取消</a>
</div>
