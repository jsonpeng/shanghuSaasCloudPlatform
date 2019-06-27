<table class="table table-responsive" id="subscribes-table">
    <thead>
        <tr>
        <th>技师</th>
        <th>时间</th>
        <th>服务</th>
        <th>门店</th>
        <th>状态</th>
        </tr>
    </thead>
    <tbody>
    @foreach($subscribes as $subscribe)
        <tr>
            <td>{!! optional($subscribe->technician()->first())->name !!}</td>
            <td>{!! $subscribe->ArriveTimeFormatHs !!}</td>
            <td>{!! optional($subscribe->service()->first())->name !!}</td>
            <td>{!! optional($subscribe->shop()->first())->name !!}</td>
            <td>{!! $subscribe->status !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>