@extends('admin.layouts.app_promp')

@section('content')
    <div class="content">
        <div class="clearfix"></div>

        @include('admin.partials.message')

        <div class="clearfix"></div>
        <div class="box box-primary form">
            <div class="box-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="javascripts:;">整体发放</span></a></li>
                        <li><a href="{!! route('coupons.given') !!}">逐个发放</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <form>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for="type">优惠券类型:</label>

                                    <select name="user_level" class="form-control">
                                        @foreach ($user_levels as $level)
                                            <option value="{{$level->id}}">{{$level->name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group col-sm-12">
                                    {!! Form::label('count', '每人发放数量:') !!}
                                    {!! Form::number('count', 1, ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group col-sm-12"> 
                                    {!! Form::label('coupons', '请选择要发放的优惠券:') !!} 
                                </div>
                                <div class="form-group col-sm-12">
                                    @foreach ($coupons as $coupon)
                                            <label style="display: inline-block; margin-right: 15px;">
                                                {!! Form::checkbox('coupons[]', $coupon->id, in_array($coupon->id, $selectedCoupons), ['class' => 'field minimal']) !!}
                                                {!! $coupon->name !!}
                                            </label>
                                    @endforeach
                                </div>
                            </div>
                            </form>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary pull-right" onclick="saveForm()">发放</button>
                            </div>
                            <!-- /.box-footer -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function saveForm(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/zcjy/coupons/given_integer",
                type:"POST",
                data:$("form").serialize(),
                success: function(data) {
                  if (data.code == 0) {
                    layer.msg(data.message, {icon: 1});
                  }else{
                    layer.msg(data.message, {icon: 5});
                  }
                },
                error: function(data) {
                  //提示失败消息

                },
            });
            
        }
    </script>
@endsection