@extends('front.default.layout.base')

@section('css')
    <style>

    </style>
@endsection

@section('content')
  @include('front.default.partial.error')

  <form action="/login" method="POST">

    {{ csrf_field() }}
    <div style="padding: 15px;">
      <div class="weui-cells__title">手机号</div>
      <div class="weui-cells">
          <div class="weui-cell">
              <div class="weui-cell__bd">
                  <input class="weui-input" type="number" name="mobile" placeholder="手机号"/>
              </div>
          </div>
      </div>
      <div class="weui-cells__title">密码</div>
      <div class="weui-cells">
          <div class="weui-cell">
              <div class="weui-cell__bd">
                  <input class="weui-input" type="password" name="password" placeholder="密码"/>
              </div>
          </div>
      </div>
    </div>
    <div class="page button js_show">

      <div class="page__bd page__bd_spacing">

        <button class="weui-btn weui-btn_primary">登录</button>

      </div>
    </div>
  </form>

  @include(frontView('layout.nav'), ['tabIndex' => 4])
@endsection


@section('js')
    <script>

    </script>
@endsection

