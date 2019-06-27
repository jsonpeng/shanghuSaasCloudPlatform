<table class="table table-responsive" id="topupGifts-table">
    <thead>
        <tr>
        <th>充值金额</th>
        <th>赠送余额</th>
        <th>赠送积分</th>
        <th>赠送优惠券</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($topupGifts as $topupGifts)
        <tr>
            <td>{!! $topupGifts->price !!}</td>
            <td>{!! $topupGifts->give_balance !!}</td>
            <td>{!! $topupGifts->give_credits !!}</td>
            <td>{!! !empty($topupGifts->coupon_id) ? $topupGifts->coupon()->first()->name : ''  !!}</td>
            <td>
                {!! Form::open(['route' => ['topupGifts.destroy', $topupGifts->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
           {{--          <a href="{!! route('topupGifts.show', [$topupGifts->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('topupGifts.edit', [$topupGifts->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>