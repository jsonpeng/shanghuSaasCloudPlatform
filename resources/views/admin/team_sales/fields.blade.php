<!-- Name Field -->
<div class="form-group col-sm-12 col-xs-12">
    <label for="name">活动名称<span class="bitian">(必填):</span></label>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Product Name Field -->
<div class="form-group col-sm-12 col-xs-12">
    <label for="name">选择产品<span class="bitian">(必选):</span></label>
    {!! Form::text('product_name', null, ['class' => 'form-control']) !!}
    <button class="btn btn-primary btn-sm daterange" type="button" title="添加产品" onclick="addProductMenuFunc(1,'',true)" style="margin-top:15px;"> <i class="fa fa-plus"></i>
    </button>
    {!! Form::hidden('product_spec', $product_spec, ['class' => 'form-control']) !!}
    <div id="seleted_one_goods">
        @if(!empty($product_spec))
            <div style="float: left;margin: 10px auto;" class="selected-group-goods">
                <div class="goods-thumb">
                    <img style="width: 162px;height: 162px" src="{!! $product->image !!}"></div>
                <div class="goods-name">
                    <a target="_blank" href="">{!! $product->name !!}</a>
                </div>
                <div class="goods-price">商城价：￥{!! $product->price !!}</div>
            </div>
        @endif
    </div>
</div>

{{-- <!-- Type Field -->
<div class="form-group col-sm-6 col-xs-6">
    {!! Form::label('type', '活动类型:') !!}
    {!! Form::select('type',[0 => '分享团', 1 => '佣金团', 2 => '抽奖团'], null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Bonus Field -->
<div class="form-group col-sm-6 col-xs-6 team_leader_bonus" id="team_leader_bonus" style="display:none;">
    {!! Form::label('bonus', '团长佣金:') !!}
    {!! Form::text('bonus', null, ['class' => 'form-control']) !!}
</div>

<!-- Lottery Count Field -->
{{-- <div class="form-group col-sm-6 col-xs-6 team_lottery_number" id="team_lottery_number" style="display:none;">
    {!! Form::label('lottery_count', '中奖人数:') !!}
    {!! Form::number('lottery_count', null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Expire Hour Field -->
{{-- <div class="form-group col-sm-6 col-xs-6">
    <label for="name">开团后有效期(小时数)<span class="bitian">(必填):</span></label>
    {!! Form::number('expire_hour', null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Price Field -->
<div class="form-group col-sm-6 col-xs-6">
    <label for="name">团购价格<span class="bitian">(必填):</span></label>
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Member Field -->
<div class="form-group col-sm-6 col-xs-6">
    <label for="name">成团人数<span class="bitian">(必填):</span></label>
    {!! Form::number('member', null, ['class' => 'form-control']) !!}
</div>

<!-- Buy Limit Field -->
<div class="form-group col-sm-6 col-xs-6">
    <label for="name">每人限购数量<span class="bitian">(必填):</span></label>
    {!! Form::number('buy_limit', null, ['class' => 'form-control']) !!}
</div>

<!-- Sales Sum Field -->
<div class="form-group col-sm-6 col-xs-6">
    {!! Form::label('sales_sum_base', '虚拟销售基数:') !!}
    {!! Form::number('sales_sum_base', null, ['class' => 'form-control']) !!}
</div>

<!-- Sort Field -->
<div class="form-group col-sm-6 col-xs-6">
    {!! Form::label('sort', '排序:') !!}
    {!! Form::number('sort', null, ['class' => 'form-control']) !!}
</div>

<!-- Share Title Field -->
<div class="form-group col-sm-12 col-xs-12">
    {!! Form::label('share_title', '分享标题:') !!}
    {!! Form::text('share_title', null, ['class' => 'form-control']) !!}
</div>

<!-- Share Des Field -->
<div class="form-group col-sm-12 col-xs-12">
    {!! Form::label('share_des', '分享描述:') !!}
    {!! Form::text('share_des', null, ['class' => 'form-control']) !!}
</div>

<!-- Share Img Field -->
<div class="form-group col-sm-12 col-xs-12">
    {!! Form::label('share_img', '分享图片:') !!}
           <div class="input-append">
                        {!! Form::text('share_img', null, ['class' => 'form-control', 'id' =>'image1']) !!}
                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image1')">更改</a>
                        <img src="@if($teamSale)
                                {{$teamSale->
                        share_img}}
                            @endif" style="max-width: 100%; max-height: 150px; display: block;">
                    </div>
</div>

<div id="product_items_table" style="display:none;"></div>
<!-- Submit Field -->
<div class="form-group col-sm-12 col-xs-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('teamSales.index') !!}" class="btn btn-default">取消</a>
</div>