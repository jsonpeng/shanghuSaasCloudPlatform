@extends('front.default.layout.base')

@section('css')
    <style>
      .weui-panel__bd{
        background-color: #fff;
      }
    </style>
@endsection

@section('content')
  @foreach($addresses as $address)
    <a class="weui-panel__bd" href="/address/select/{{$address->id}}">
      <div class="weui-media-box weui-media-box_text">
        <h4 class="weui-media-box__title">{{ $address->name }} {{ $address->phone }}</h4>
        <p class="weui-media-box__desc">{{ $address->province }}{{ $address->city }}{{ $address->district }}{{ $address->detail }}</p>
      </div>
      <!--div class="weui-cell weui-cell_switch">
        <div class="weui-cell__bd">默认收货地址</div>
        <div class="weui-cell__ft">
            <input class="weui-switch" type="checkbox" @if($address->default == 'true') checked="checked" @endif />
        </div>
      </div-->
    </a>
  @endforeach
  

  <div class="page">
    <div class="page__bd page__bd_spacing">
      @if ($addresses->count() < 10)
        <a href="/address/add?backupcheck={{$backupcheck}}" class="weui-btn weui-btn_primary">使用新收货地址</a>
      @endif
      <a href="/check" class="weui-btn weui-btn_default">返回</a>
    </div>
  </div>


  @include(frontView('layout.nav'), ['tabIndex' => 4])
@endsection


@section('js')
    <script>

    </script>
@endsection

