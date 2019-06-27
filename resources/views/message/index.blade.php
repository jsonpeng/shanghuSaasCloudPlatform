@extends('admin.layouts.app')

@section('content')
    <section class="content-header mb10-xs">
        <h1 class="pull-left">站内信</h1>
  {{--       <h1 class="pull-right">
           <a class="btn btn-primary pull-right" href="{!! route('banners.create') !!}">添加</a>
        </h1> --}}
    </section>
    <div class="content pdall0-xs">
        <div class="clearfix"></div>

        @include('admin.partials.message')

        <div class="clearfix"></div>

<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">共{{ count($notices) }}封，其中{{ count($unreadNotices) }}封未读@if(count($unreadNotices)),<a href="javascript:;" class="read_all_message">全部已读</a>@endif</h3>

              <!--全部已读表单-->
              {!! Form::open(['route' => ['message.update', 0], 'method' => 'patch','class'=> 'message_all']) !!}
                    <input type="hidden" name="read_all" value="1">
              {!! Form::close() !!}

              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">
              </div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped" id="message">
                     <thead>
                      <tr>
                      <th>时间</th>
                      <th>阅读状态</th>
                      <th>消息类型</th>
                      <th>消息内容</th>
                      <th>操作</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach ($notices as $notice)
                      <tr>
               
                        <td>{{ $notice->currentTime }}</td>
                        <td>@if(!empty($notice->read_at)) 已读 @else 未读 @endif</td>
                        <td>{{ $notice->data['type'] }}</td>
                        <td><b>{!! $notice->data['content'] !!}</b>
                        </td>
                        <td>
                          <div class="btn-group">
                          {!! Form::open(['route' => ['message.update', $notice->id], 'method' => 'patch']) !!}
                             <button class="btn btn-{{ !empty($notice->read_at) ? 'success' : 'danger'}} btn-xs" >@if(!empty($notice->read_at)) 已读 @else 未读 @endif</button>
                               @if(!empty($notice->read_at))
                               <input type="hidden" name="read_at" value="0">
                               @else
                               <input type="hidden" name="read_at" value="1">
                               @endif
                          {!! Form::close() !!}
                          {!! Form::open(['route' => ['message.destroy', $notice->id], 'method' => 'delete']) !!}
                          <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('确定要删除吗?')"><i class="glyphicon glyphicon-trash"></i></button>
                          {!! Form::close() !!}
                          </div>
                        
                        </td>
                        {{-- <td class="mailbox-attachment"></td> --}}
                      
                      </tr>
                    @endforeach
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              <div class="mailbox-controls">
            
              </div>
            </div>
</div>


</div>
@endsection


@section('scripts')
<script src="{{  asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{  asset('vendor/datatables/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript">
  var pagenate ={!! count($notices) !!}  > 10 ? true : false;
  $(function(){
    //form样式
    $('form').attr('style','display:inline-block;');
    //自动分页
    $('#message').DataTable({
            "paging": pagenate,
            "lengthChange": false,
            "searching": true,
            "ordering": false,
            "info": false,
            "autoWidth": true,
            "bSort": false, 
            "bLengthChange":1,
            "oLanguage":{
              "sZeroRecords": "对不起，查询不到任何相关数据", 
              "sSearch": "搜索:", 
              "oPaginate": {
                  "sPrevious": " 上一页 ",
                  "sNext":     " 下一页 ",
              }
        },
    });
    //去除显示
    console.log($('#message_wrapper').find('.col-sm-6').eq(0).remove());
    $('#message_wrapper').find('.col-sm-6').eq(0).attr('style','margin-left:10px;');
    //全部已读
    $('.read_all_message').click(function(){
      $('.message_all').submit();
    });
  }); 
</script>
@endsection