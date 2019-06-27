<table class="table table-responsive" id="productPromps-table">
    <thead>
        <tr>
            <th>名称</th>
            <th>类型</th>
            <th>金额/折扣</th>
            <th>状态</th>
            <th class="hidden-xs">开始时间</th>
            <th class="hidden-xs">结束时间</th>
            <th class="hidden-sm hidden-xs">创建时间</th>
            <th colspan="3" class="hidden-xs">操作</th>
            <th class="visible-xs">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($productPromps as $productPromp)
        <tr>
            <td>{!! $productPromp->name !!}</td>
            <td>{!! $productPromp->typeName !!}</td>
            <td>{!! $productPromp->value !!}</td>
            <td>{!! $productPromp->status !!}</td>
            <td class="hidden-xs">{!! $productPromp->time_begin !!}</td>
            <td class="hidden-xs">{!! $productPromp->time_end !!}</td>
            <td class="hidden-sm hidden-xs">{!! $productPromp->created_at !!}</td>
            <td>
                {!! Form::open(['route' => ['productPromps.destroy', $productPromp->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="javascript:;" onclick="addProductMenuFunc(2,{!! $productPromp->id !!})" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('productPromps.edit', [$productPromp->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>