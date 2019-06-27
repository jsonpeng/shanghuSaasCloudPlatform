<!-- No Field -->
<div class="form-group col-sm-6">
    {!! Form::label('no', '单号:') !!}
    {!! Form::text('no', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->


<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', '类型:') !!}
    {!! Form::text('type', null, ['class' => 'form-control']) !!}
    {!! Form::hidden('user_id', null, ['class' => 'form-control']) !!}
    
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', '交易金额:') !!}
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', '交易状态:') !!}
 
      <select name="status" class="form-control"  @if($withDrawl->status == '撤回') disabled @endif>
            <option value="发起" @if($withDrawl->status == '发起') selected @endif>发起</option>
            <option value="处理中" @if($withDrawl->status == '处理中') selected @endif>处理中</option>
            <option value="已完成" @if($withDrawl->status == '已完成') selected @endif>已完成</option>
            <option value="撤回" @if($withDrawl->status == '撤回') selected @endif>撤回</option>
    </select>

</div>

<!-- Arrive Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('arrive_time', '到账时间:') !!}
    <div class='input-group date' id='datetimepicker'>
    {!! Form::text('arrive_time', null, ['class' => 'form-control']) !!}
    <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
    </span>
    </div>
</div>



<!-- Account Tem Field -->
<div class="form-group col-sm-6">
    {!! Form::label('account_tem', '临时余额:') !!}
    {!! Form::text('account_tem', null, ['class' => 'form-control']) !!}
</div>

<!-- Card Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('card_name', '银行卡名称:') !!}
    {!! Form::text('card_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Card No Field -->
<div class="form-group col-sm-6">
    {!! Form::label('card_no', '银行卡号:') !!}
    {!! Form::text('card_no', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('withDrawls.index') !!}" class="btn btn-default">返回</a>
</div>
