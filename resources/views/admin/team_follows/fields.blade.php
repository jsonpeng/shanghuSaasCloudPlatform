<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
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
    {!! Form::number('order_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Found Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('found_id', 'Found Id:') !!}
    {!! Form::number('found_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Found User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('found_user_id', 'Found User Id:') !!}
    {!! Form::number('found_user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Team Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('team_id', 'Team Id:') !!}
    {!! Form::number('team_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::number('status', null, ['class' => 'form-control']) !!}
</div>

<!-- Is Winner Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_winner', 'Is Winner:') !!}
    {!! Form::number('is_winner', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('teamFollows.index') !!}" class="btn btn-default">Cancel</a>
</div>
