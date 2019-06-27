@extends('front.default.layout.base')

@section('css')
    <style>
      .weui-panel__bd{
        background-color: #fff;
      }
      body{
        background-color: #fff;
      }
    </style>
@endsection

@section('content')

  @include('front.default.partial.error')
  <div class="nav_tip">
    <div class="img">
      <a href="javascript:history.back(-1)"><i class="icon ion-ios-arrow-left"></i></a></div>
    <p class="titile">添加地址</p>
  </div>
  <form action="/address/add" method="POST">

    {{ csrf_field() }}

    <div class="weui-cells weui-cells_form">
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">收件人</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" placeholder="收件人" name="name" maxlength="10" />
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">电话</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" placeholder="电话" name="phone" maxlength="11" />
        </div>
    </div>
    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">省</label>
        </div>
        <div class="weui-cell__bd">
            <select id="province" name="province" class="weui-select">  
              <option value="0">请选择省份</option>
              @foreach($cities as $item)
                  <option value="{!! $item->id !!}">{!! $item->name !!}</option>
              @endforeach
            </select>
        </div>
    </div>
    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">市</label>
        </div>
        <div class="weui-cell__bd">
          <select id="city" name="city" class="weui-select"></select>
        </div>
    </div>
    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">区</label>
        </div>
        <div class="weui-cell__bd">
          <select id="district" name="district" class="weui-select"></select>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">详细地址</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" placeholder="详细地址" name="detail" maxlength="128" />
        </div>
    </div>
  </div>
  <div class="weui-panel__bd">
    
    <div class="weui-cell weui-cell_switch">
      <div class="weui-cell__bd">默认收货地址</div>
      <div class="weui-cell__ft">
          <input class="weui-switch" type="checkbox" name="default" />
      </div>
    </div>
  </div>
  

  <div class="page">
    <div class="page__bd page__bd_spacing">
      <button class="weui-btn weui-btn_primary">保存</button>
      <a href="javascript:history.back(-1)" class="weui-btn weui-btn_default">返回</a>
    </div>
  </div>
  </form>
  


  @include(frontView('layout.nav'), ['tabIndex' => 4])
@endsection


@section('js')
    @include('front.default.address.js')
@endsection

