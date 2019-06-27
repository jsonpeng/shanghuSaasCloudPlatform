<!-- Title Field -->
<div class="col-md-12">
	<div class="form-group ">
	    {!! Form::label('title', '主题名称:') !!}
	    {!! Form::text('title', null, ['class' => 'form-control']) !!}
	</div>

	<!-- Subtitle Field -->
	<div class="form-group">
	    {!! Form::label('subtitle', '主题副标题:') !!}
	    {!! Form::text('subtitle', null, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group style="margin-top: 20px;">
        {!! Form::label('cover', '商品图片:') !!}
        <div class="input-append">
            {!! Form::text('cover', null, ['class' => 'form-control', 'id' => 'image']) !!}
            <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button">更改</a>
            <img src="@if($theme)
                {{$theme->cover}}
            @endif" style="max-width: 100%; max-height: 150px; display: block;">
        </div>
    </div>    

	<!-- Intro Field -->
	<div class="form-group">
	    {!! Form::label('intro', '主题介绍:') !!}
	    {!! Form::textarea('intro', null, ['class' => 'form-control intro']) !!}
	</div>	

	<h3>专题商品</h3>
	@foreach ($cats as $cat)
		<div class="box box-solid">
			<div class="box-header with-border">
				<h4 class="box-title">{{$cat->name}}</h4>
			</div><!-- /.box-header -->
			<div class="box-body">
				@foreach ($cat->products_name as $product)
					<div class="product-list">
						<img src="{{$product->image}}" style="height: 100px; width: auto;"></br>
		                <label style="margin-left: 10px;">
		                    {!! Form::checkbox('products[]', $product->id, in_array($product->id, $selectedProducts), ['class' => 'field minimal']) !!}
		                    {!! $product->name !!}
		                </label>
					</div>
				@endforeach
			</div><!-- /.box-body -->
		</div>
	@endforeach

	<!-- Submit Field -->
	<div class="form-group">
	    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
	    <a href="{!! route('themes.index') !!}" class="btn btn-default">取消</a>
	</div>
</div>