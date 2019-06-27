<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Order Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order_id', 'Order Id:') !!}
    {!! Form::number('order_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Mobile Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mobile', 'Mobile:') !!}
    {!! Form::text('mobile', null, ['class' => 'form-control']) !!}
</div>

<!-- Team Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('team_id', 'Team Id:') !!}
    {!! Form::text('team_id', null, ['class' => 'form-control']) !!}
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

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('teamLotteries.index') !!}" class="btn btn-default">Cancel</a>
</div>
