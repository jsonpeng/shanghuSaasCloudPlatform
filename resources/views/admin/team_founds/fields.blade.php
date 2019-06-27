<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Time Begin Field -->
<div class="form-group col-sm-6">
    {!! Form::label('time_begin', 'Time Begin:') !!}
    {!! Form::text('time_begin', null, ['class' => 'form-control']) !!}
</div>

<!-- Time End Field -->
<div class="form-group col-sm-6">
    {!! Form::label('time_end', 'Time End:') !!}
    {!! Form::text('time_end', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Team Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('team_id', 'Team Id:') !!}
    {!! Form::number('team_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Nickname Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nickname', 'Nickname:') !!}
    {!! Form::text('nickname', null, ['class' => 'form-control']) !!}
</div>

<!-- Head Pic Field -->
<div class="form-group col-sm-6">
    {!! Form::label('head_pic', 'Head Pic:') !!}
    {!! Form::text('head_pic', null, ['class' => 'form-control']) !!}
</div>

<!-- Order Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order_id', 'Order Id:') !!}
    {!! Form::text('order_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Join Num Field -->
<div class="form-group col-sm-6">
    {!! Form::label('join_num', 'Join Num:') !!}
    {!! Form::number('join_num', null, ['class' => 'form-control']) !!}
</div>

<!-- Need Mem Field -->
<div class="form-group col-sm-6">
    {!! Form::label('need_mem', 'Need Mem:') !!}
    {!! Form::number('need_mem', null, ['class' => 'form-control']) !!}
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Origin Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('origin_price', 'Origin Price:') !!}
    {!! Form::text('origin_price', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::number('status', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('teamFounds.index') !!}" class="btn btn-default">Cancel</a>
</div>
