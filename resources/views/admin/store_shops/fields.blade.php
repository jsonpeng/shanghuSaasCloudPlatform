<!-- Name Field -->
<div class="form-group col-sm-8">
    <label for="name">店铺名称<span class="bitian">(必填):</span></label>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Address Field -->
<div class="form-group col-sm-8">
    <label for="address">店铺地址<span class="bitian">(必填):</span></label>
    {!! Form::text('address', null, ['class' => 'form-control','placeholder'=>'请输入具体地址后在地图中确定']) !!}
   {{--  <div class="input-append">
            <a class="btn" onclick="openMap('address')">在地图中设定</a>
    </div> --}}
</div>


<div class="form-group col-sm-8 map" style="margin: 0 auto;display: none;">
    <div id="allmap" style="height: 300px;"></div>
</div>


<!-- Jindu Field -->
<div class="form-group col-sm-8">
    {!! Form::label('jindu', '经度:') !!}
    {!! Form::text('jindu', null, ['class' => 'form-control']) !!}
</div>

<!-- Weidu Field -->
<div class="form-group col-sm-8">
    {!! Form::label('weidu', '纬度:') !!}
    {!! Form::text('weidu', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-8">
    <label for="contact_man">联系人</label>
    {!! Form::text('contact_man', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-8">
    <label for="weixin">微信</label>
    {!! Form::text('weixin', null, ['class' => 'form-control']) !!}
</div>

<!-- Tel Field -->
<div class="form-group col-sm-8">
    <label for="tel">客服电话<span class="bitian">(必填):</span></label>
    {!! Form::text('tel', null, ['class' => 'form-control']) !!}
</div>

<!-- Logo Field -->
<div class="form-group col-sm-8">
    {!! Form::label('logo', '店铺Logo:') !!}
    {!! Form::text('logo', null, ['class' => 'form-control','id' => 'image']) !!}
    <div class="input-append">
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image')">选择图片</a>
        <img src="@if(!empty($storeShop)) {{ $storeShop->logo }} @endif" style="max-width: 100%; max-height: 150px; display: block;">
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('storeShops.index') !!}" class="btn btn-default">返回</a>
</div>
