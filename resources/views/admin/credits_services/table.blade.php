<table class="table table-responsive" id="creditsServices-table">
    <thead>
        <tr>
        <th>兑换标题</th>
        <th>显示图片</th>
        <th>兑换类型</th>
        <th>服务</th>
        <th>需要积分</th>
        <th>兑换次数(人气)</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($creditsServices as $creditsService)
        <tr>
            <td>{!! $creditsService->name !!}</td>
            <td>{!! $creditsService->image !!}</td>
            <td>{!! $creditsService->type !!}</td>
            <td>@if($creditsService->type  == '服务') {!! a_link(optional($creditsService->service()->first())->name,route('services.edit',optional($creditsService->service()->first())->id),'orange',false) !!} @else -- @endif</td>
            <td>{!! $creditsService->need_num !!}</td>
            <td>{!! $creditsService->count_time !!}</td>
            <td>
                {!! Form::open(['route' => ['creditsServices.destroy', $creditsService->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                 {{--    <a href="{!! route('creditsServices.show', [$creditsService->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('creditsServices.edit', [$creditsService->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>