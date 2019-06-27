<!-- Price Field -->
<div class="form-group col-sm-8">
    {!! Form::label('price', '充值金额:') !!}
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Give Balance Field -->
<div class="form-group col-sm-8">
    {!! Form::label('give_balance', '赠送余额:') !!}
    {!! Form::text('give_balance', null, ['class' => 'form-control']) !!}
</div>

<!-- Give Credits Field -->
<div class="form-group col-sm-8">
    {!! Form::label('give_credits', '赠送积分:') !!}
    {!! Form::text('give_credits', null, ['class' => 'form-control']) !!}
</div>

<!-- Coupon Id Field -->
<div class="form-group col-sm-8">
{{--     {!! Form::label('coupon_id', '赠送优惠券:') !!} --}}
  {{--   {!! Form::text('coupon_id', null, ['class' => 'form-control']) !!} --}}
    <div class="form-group " style="overflow: hidden;">
        <label for="services">选择赠送优惠券</label>
       <button class="btn btn-primary btn-sm daterange " type="button" title="选择优惠券" onclick="addCouponMenuFunc()"> <i class="fa fa-plus"></i>
       </button>   
    </div>

           <div id="services_items" class="form-group" style="display:{!! empty($topupGifts) ?'none':'block' !!};margin-top:20px;">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">赠送优惠券信息</h3>
                                                </div>
                                                <div  class="box-body" >
                                                    <div class="row" style="background-color: #edfbf8;">
                                                        <div class="col-md-6 col-xs-6">优惠券名称</div>
                                                    
                                                  {{--       <div class="col-md-4 col-xs-4">服务价格(元)</div> --}}
                                                        <div class="col-md-6 col-xs-6">操作</div>
                                                    </div>
                                                    @if (!empty($topupGifts))
                                                         @if(!empty($coupon)) 
                                                           
                                                                <div class="items row" style="border-bottom: 1px solid #f4f4f4">
                        
                                                                        <div class="col-md-6 col-xs-6">
                                                                            {{ $coupon->name }}
                                                                        </div>


                                                                        <div class="col-md-6 col-xs-6">
                                                                            <div class='btn-group' style="padding: 8px;">
                                                                                <a href="javascript:;" class='btn btn-danger btn-xs'  onclick="delServiceItem(this)"> <i class="glyphicon glyphicon-trash" title="确认"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" name="coupon_id" value="{{ $coupon->id }}" />
                                                                </div>
                                                         @endif
                                                    @endif
                                                </div>
                                        </div>
                                          <div id="services_items_table" style="display:none;"></div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('topupGifts.index') !!}" class="btn btn-default">返回</a>
</div>
