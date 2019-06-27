<table class="table table-responsive" id="services-table">
    <thead>
        <tr>
        <th>服务名称</th>
        <th>服务类型</th>
        <th>提成</th>
   {{--      <th>适用店铺</th> --}}
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($services as $services)
        <tr>
            <td>{!! $services->name !!} @if($services->all_use == 1) {!! tag('[全场通用]') !!} @endif</td>
            <td>{!! $services->Type !!}</td>
            <td>{!! $services->commission !!}</td>
           {{--  <td>{!! $services->ShopsHtml !!} </td> --}}
            <td>
                @if($services->all_use == 1 || admin()->shop_type) 
                    {!! Form::open(['route' => ['services.destroy', $services->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <!--<a href="{!! route('services.show', [$services->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>-->
                        <a href="{!! route('services.edit', [$services->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>