<!-- Name Field -->
<div class="form-group col-sm-8">
    <label for="name">服务名称<span class="bitian">(必填):</span></label>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-8">
    {!! Form::label('image', '服务图片:') !!}
    {!! Form::text('image', null, ['class' => 'form-control','id' => 'image']) !!}
    <div class="input-append">
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image')">选择图片</a>
        <img src="@if(!empty($services)) {{ $services->image }} @endif" style="max-width: 100%; max-height: 150px; display: block;">
    </div>
</div>

<!-- Intro Field -->
<div class="form-group col-sm-8 col-lg-8">
    {!! Form::label('intro', '服务介绍:') !!}
    {!! Form::textarea('intro', null, ['class' => 'form-control']) !!}
</div>

{{-- <div class="form-group col-sm-12" style="overflow: hidden;">
    <label for="name">适用店铺<span class="bitian">(必选):</span></label>
    @if(count($shops))
        @foreach ($shops as $shop)
            <div style="margin-right: 20px;">
                <label>
                    {!! Form::checkbox('shops[]', $shop->id, in_array($shop->id, $selectedShops), ['class' => 'select_shop']) !!}
                        {!! $shop->name !!}
                </label>
            </br>
            </div>
        @endforeach
    @else
        <a href="{!! route('storeShops.create') !!}">请先创建店铺</a>
    @endif
</div> --}}

<!-- Time Type Field -->
<div class="form-group col-sm-8">
    {!! Form::label('time_type', '类型:') !!}
    {!! Form::select('time_type', [0 => '固定有效日期', 1 => '固定多少天后'], null , ['class' => 'form-control']) !!}
</div>

<!-- Expire Days Field -->
<div class="form-group col-sm-8" @if (empty($services) || !empty($services) && $services->
    time_type == 0) style="display: none;" @endif>
    <label for="expire_days">固定多少天后<span class="bitian">(必填):</span></label>
    {!! Form::text('expire_days', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6" @if (!empty($services) && $services->
    time_type == 1) style="display: none;" @endif>
    <label for="time_begin">有效期(起始)<span class="bitian">(必填):</span></label>
    <div class='input-group date' id='datetimepicker_begin'>
        {!! Form::text('time_begin', null, ['class' => 'form-control']) !!}
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>

<div class="form-group col-sm-6" @if (!empty($services) && $services->
    time_type == 1) style="display: none;" @endif>
    <label for="time_end">有效期(结束)<span class="bitian">(必填):</span></label>
    <div class='input-group date' id='datetimepicker_end'>
        {!! Form::text('time_end', null, ['class' => 'form-control']) !!}
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>

<!-- Commission Field -->
<div class="form-group col-sm-8">
    <label for="name">提成<span class="bitian">(必填):</span></label>
    {!! Form::text('commission', null, ['class' => 'form-control']) !!}
</div>

@if(admin()->shop_type)
    <?php $admin_package = getAdminPackageStatus();?>
    @if($admin_package['package']['canuse_shop_num'] > 1)
        <div class="form-group col-sm-8">
            {!! Form::checkbox('all_use', 1, !empty($services) && $services->all_use ? 1 : 0, ['class' => 'field minimal']) !!}全场通用
        </div>
    @endif
@endif
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('services.index') !!}" class="btn btn-default">返回</a>
</div>
