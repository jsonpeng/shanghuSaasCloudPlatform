@extends('admin.layouts.app_shop')

@section('css')
  <style type="text/css">
    .has-feedback .form-control{
      padding-right: 5px;
    }
  </style>
  
@endsection

@section('content')
    <div class="container-fluid" style="padding: 30px 15px;">
        <!-- Content Header (Page header) -->
        <section class="content-header" style="padding-top: 0;">
          <h1>
            用户信息
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">

          <div class="row">
            <div class="col-md-3">

              <!-- Profile Image -->
              <div class="box box-primary">
                <div class="box-body box-profile">
                  <img class="profile-user-img img-responsive img-circle" style="height: 100px;" src="{{ $user->head_image }}">

                  <h3 class="profile-username text-center">{{ $user->nickname }}</h3>


                  <!--p class="text-muted text-center">
                    @if($user->lock)
                        <span class="label label-danger">账户被冻结</span>
                    @else
                        <span class="label label-success">账户正常</span>
                    @endif
                    
                </p-->

                  <ul class="list-group list-group-unbordered">

                    @if (funcOpen('FUNC_CREDITS'))
                    <li class="list-group-item" >
                      <b>积分</b><a id="creditsEdit"  data-id="{{ $user->id }}" class="label label-success pull-right">修改</a><span class="pull-right" style="display: inline-block;padding-right: 10px;">{{ $user->credits }}</span> 
                    </li>
                    @endif

                    @if (funcOpen('FUNC_FUNDS'))
                    <li class="list-group-item" >
                      <b>余额</b><a id="userMoneyEdit"  data-id="{{ $user->id }}" class="label label-success pull-right">修改</a><span class="pull-right" style="display: inline-block;padding-right: 10px;">{{ $user->user_money }}</span>
                    </li>
                    @endif
                    <li class="list-group-item">
                      <b>总消费</b> <span class="pull-right">{{ $user->consume_total }}</span>
                    </li>
                  </ul>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->

              <!-- About Me Box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">其他信息</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <ul class="list-group list-group-unbordered">
                        @if (funcOpen('FUNC_MEMBER_LEVEL'))
                        <li class="list-group-item">
                          <b>会员等级</b> <span class="pull-right">{{ $userLevel->name }}</span>
                        </li>
                        @endif

                        <li class="list-group-item">
                          <b>注册时间</b> <span class="pull-right">{{ $user->created_at }}</span>
                        </li>
                        <li class="list-group-item">
                          <b>电话</b> <span class="pull-right">{{ $user->mobile }}</span>
                        </li>
                        <li class="list-group-item">
                          <b>最后活跃时间</b> <span class="pull-right">{{ $user->last_login }}</span>
                        </li>
                    </ul>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">

                  <li class="@if(array_key_exists('type',$input) && $input['type'] == 'order' || !count($input)) active @endif"><a href="#order_list" data-toggle="tab">订单</a></li>

                  <li class="@if(array_key_exists('type',$input) && $input['type'] == 'service') active @endif"><a href="#service" data-toggle="tab">他的服务</a></li>

                  <li><a href="#unread" data-toggle="tab">未读消息</a></li>

                  @if (funcOpen('FUNC_CREDITS'))
                    <li><a href="#credits_log" data-toggle="tab">积分记录</a></li>
                  @endif

                  @if (funcOpen('FUNC_FUNDS'))
                  <li><a href="#funds_log" data-toggle="tab">账户记录</a></li>
                  @endif

                  @if (funcOpen('FUNC_DISTRIBUTION'))
                  <li><a href="#share_code" data-toggle="tab">推广二维码</a></li>
                  @endif
                  
                </ul>
                <div class="tab-content">
                  <div class="@if(array_key_exists('type',$input) && $input['type'] == 'order' || !count($input)) active @endif tab-pane" id="order_list">
                    <table class="table table-responsive" id="refundLogs-table">
                        <thead>
                            <tr>
                                <th>订单编号</th>
                                <th>订单金额</th>
                                <th>订单状态</th>
                                <th>物流状态</th>
                                <th>支付状态</th>
                                <th>下单时间</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td><a href="/zcjy/orders/{!! $order->id !!}" target="_blank">{!! $order->snumber !!}</a></td>
                                <td>{!! $order->price !!}</td>
                                <td>{!! $order->order_status !!}</td>
                                <td>{!! $order->order_delivery !!}</td>
                                <td>{!! $order->order_pay !!}</td>
                                <td>{!! $order->created_at !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        {!! $orders->appends(['type'=>'order'])->links() !!}
                    </div>
                  </div>

                  <!-- 服务 -->
                    <div class="@if(array_key_exists('type',$input) && $input['type'] == 'service') active @endif tab-pane" id="service">
                    <table class="table table-responsive" id="refundLogs-table">
                        <thead>
                            <tr>
                                <th>服务名称</th>
                                <th>剩余次数</th>
                                <th>服务时间(起)</th>
                                <th>服务时间(止)</th>
                                <th>适用门店</th>
                                <th>当前状态</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($services as $service)
                            <tr>
                                <td><a href="/zcjy/services/{{ $service->id }}/edit" target="_blank">{!! $service->name !!}</a></td>
                                <td>{!! $service->pivot->num !!}</td>
                                <td>{!! $service->pivot->time_begin !!}</td>
                                <td>{!! $service->pivot->time_end !!}</td>
                                <td>{!! $service->ShopsHtml !!}</td>
                                <td>{!! $service->pivot->status !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        {!! $services->appends(['type'=>'service'])->links() !!}
                    </div>
                  </div>

                  <!--未读消息 unread-->
                  <div class="tab-pane" id="unread">
                    <table class="table table-responsive" id="refundLogs-table">
                        <thead>
                            <tr>
                                <th>消息类型</th>
                                <th>消息内容</th>
                                <th>时间</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($unreadMessages as $message)
                            <tr>
                                <td>{!! $message->data['type'] !!}</td>
                                <td>{!! $message->data['content'] !!}</td>
                                <td>{!! $message->currentTime !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                  
                    </div>
                  </div>

                  @if (funcOpen('FUNC_CREDITS'))
                  <div class="tab-pane" id="credits_log">
                    <table class="table table-responsive" id="refundLogs-table">
                        <thead>
                            <tr>
                                <th>积分余额</th>
                                <th>变动记录</th>
                                <th>备注</th>
                                <th>时间</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($credits as $credit)
                            <tr>
                                <td>{!! $credit->amount !!}</td>
                                <td>{!! $credit->change !!}</td>
                                <td>{!! $credit->detail !!}</td>
                                <td>{!! $credit->created_at !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                  </div>
                  @endif

                  @if (funcOpen('FUNC_FUNDS'))
                  <div class="tab-pane" id="funds_log">
                    <table class="table table-responsive" id="refundLogs-table">
                        <thead>
                            <tr>
                                <th>余额</th>
                                <th>变动记录</th>
                                <th>备注</th>
                                <th>时间</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($funds as $fund)
                            <tr>
                                <td>{!! $fund->amount !!}</td>
                                <td>{!! $fund->change !!}</td>
                                <td>{!! $fund->detail !!}</td>
                                <td>{!! $fund->created_at !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                  </div>
                  @endif
                  <!-- /.tab-pane -->

                  @if (funcOpen('FUNC_DISTRIBUTION'))
                  <div class="tab-pane" id="share_code">
                    <img src="{{ $share_img }}" alt="">
                  </div>
                  @endif
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div>
              <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

        </section>
    </div>
@endsection


@include('admin.user.js')
