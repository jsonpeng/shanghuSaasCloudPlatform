@extends('admin.layouts.app_promp')

@section('content')
    <section class="content-header">
        <h1>
            Coupon
        </h1>
    </section>
    <div class="content">
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row" style="padding-left: 20px">
                        
                            <table class="table table-responsive" id="coupons-table">
                                <thead>
                                    <th>编号</th>
                                    <th>名称</th>
                                    <th>有效期(起)</th>
                                    <th>有效期(终)</th>
                                    <th>类型</th>
                                    <th>最低金额</th>
                                    <th>优惠金额</th>
                                    <th>折扣</th>
                                    <th>承担部门</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{!! $coupon->id !!}</td>
                                        <td>{!! $coupon->name !!}</td>
                                        <td>{!! $coupon->time_begin !!}</td>
                                        <td>{!! $coupon->time_end !!}</td>
                                        <td>{!! $coupon->type !!}</td>
                                        <td>{!! $coupon->base !!}</td>
                                        <td>{!! $coupon->given !!}</td>
                                        <td>{!! $coupon->discount !!}</td>
                                        <td>{!! $coupon->department !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                    </div>
                </div>
            </div>
            <a href="{!! route('coupons.index') !!}" class="btn btn-default">返回</a>
        </div>
    </div>
@endsection
