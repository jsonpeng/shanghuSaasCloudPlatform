<!-- Name Field -->
<div class="form-group col-sm-12">
    <label for="name">活动名称<span class="bitian">(必填):</span></label>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-12">
    {!! Form::label('type', '活动类型:') !!}
    {!! Form::select('type', [0 => '打折优惠', 1 => '减价优惠'], null , ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    <label for="name">满足金额<span class="bitian">(必填):</span></label>
    {!! Form::text('base', null, ['class' => 'form-control']) !!}
    <p class="help-block">需满足的最低消费金额</p>
</div>

<!-- Value Field -->
<div class="form-group col-sm-12 changeText">
    {!! Form::label('value', '折扣') !!}<span class="bitian">(必填):</span>
    {!! Form::text('value', null, ['class' => 'form-control']) !!}
    <p class="help-block">请输入折扣(%)，85折就输入85， 7折就输入70</p>
</div>

<div class="form-group col-sm-6">
    <label for="name">开始时间<span class="bitian">(必填):</span></label>
    <div class='input-group date' id='datetimepicker_begin'>
        {!! Form::text('time_begin', null, ['class' => 'form-control']) !!}
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>

<div class="form-group col-sm-6">
    <label for="name">结束时间<span class="bitian">(必填):</span></label>
    <div class='input-group date' id='datetimepicker_end'>
        {!! Form::text('time_end', null, ['class' => 'form-control']) !!}
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>

<!-- Intro Field 
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('intro', '活动介绍:') !!}
    {!! Form::textarea('intro', null, ['class' => 'form-control']) !!}
</div>-->

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('productPromps.index') !!}" class="btn btn-default">取消</a>
</div>
