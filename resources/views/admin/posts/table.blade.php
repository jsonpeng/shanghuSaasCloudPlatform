<table class="table table-responsive" id="posts-table">
    <thead>
        <tr>
            <th>名称</th>
            <th>分类</th>
            <th>发布</th>
            <th>发布人</th>
            <th>链接</th>
            <th>浏览量</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($posts as $post)
        <tr>
            <td>{!! empty($post->name) ? subdes($post->content,10) : $post->name !!}</td>
            <td>@foreach ($post->cats as $cat)
                &nbsp;{{$cat->name}}
            @endforeach</td>
            <td>{!! $post->publish !!}</td>
            <th>@if($post->is_admin) {!! tag('[商户]').$post->admin()->first()->nickname !!} @else {!! tag('[用户]').$post->user()->first()->nickname !!} @endif</th>
            <td>{!! $baseurl !!}/post/{!! $post->id !!}</td>
            <td>{!! $post->view !!}</td>
            <td>
                {!! Form::open(['route' => ['posts.destroy', $post->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
            {{--         <a href="{!! $baseurl !!}/post/{!! $post->id !!}" target="_blank" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('posts.edit', [$post->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                 
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>