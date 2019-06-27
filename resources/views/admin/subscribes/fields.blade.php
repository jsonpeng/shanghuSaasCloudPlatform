<!-- Subman Field -->
<div class="form-group col-sm-8">
    <label for="subman">预约人<span class="bitian">(必填):</span></label>
    {!! Form::text('subman', null, ['class' => 'form-control']) !!}
</div>

<!-- Mobile Field -->
<div class="form-group col-sm-8">
    <label for="mobile">手机号<span class="bitian">(必填):</span></label>
    {!! Form::text('mobile', null, ['class' => 'form-control']) !!}
</div>

{{-- <!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::text('user_id', null, ['class' => 'form-control']) !!}
</div> --}}
<!-- Arrive Time Field -->
{{-- <div class="form-group col-sm-8">
    {!! Form::label('arrive_time', '到店时间:') !!}
    {!! Form::text('arrive_time', null, ['class' => 'form-control']) !!}
</div>
 --}}
<div class="form-group col-sm-8">
     <label for="arrive_time">到店时间<span class="bitian">(必填):</span></label>
        <div class='input-group date' id='datetimepicker_arrivetime'>
            {!! Form::text('arrive_time', null , ['class' => 'form-control', 'maxlength' => '10']) !!}
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
</div>

<!-- Shop Id Field -->
<div class="form-group col-sm-8">
    <label for="shop_id">预约门店<span class="bitian">(必选):</span></label>
   {{--  {!! Form::text('shop_id', null, ['class' => 'form-control']) !!} --}}
    @if(count($shops))
    <select name="shop_id" class="form-control">
             <option value="" @if(empty($subscribe)) selected="selected" @endif>请选择门店</option>
        @foreach ($shops as $item)
             <option value="{{ $item->id }}" @if(!empty($subscribe) && $item->id == $subscribe->shop_id) selected="selected" @endif>{{ $item->name }}</option>
        @endforeach
    </select>
    @else
    <a href="{!! route('storeShops.create') !!}">添加门店</a>
    @endif
</div>

<!-- Service Id Field -->
<div class="form-group col-sm-8 sevices_box"  @if(empty($subscribe)) style="display: none;" @endif>
    <label for="service_id">预约服务<span class="bitian">(必选):</span></label>
    {{-- {!! Form::text('service_id', null, ['class' => 'form-control']) !!} --}}
    <select name="service_id" class="form-control">
             <option value="" @if(empty($subscribe)) selected="selected" @endif>请选择服务</option>
             @if(!empty($subscribe))
                 @if(count($selectedServices))
                    @foreach($selectedServices as $k => $item)
                        <option value="{{ $item->id }}" @if(!empty($subscribe) && $item->id == $subscribe->service_id) selected="selected" @endif>{{ $item->name }}</option>
                    @endforeach
                 @endif
             @endif
    </select>
</div>

<!-- Technician Id Field -->
<div class="form-group col-sm-8 technician_box" @if(empty($subscribe)) style="display: none;" @endif>
    <label for="technician_id">预约技师<span class="bitian">(必选):</span></label>
{{--     {!! Form::text('technician_id', null, ['class' => 'form-control']) !!} --}}
    <select name="technician_id" class="form-control">
             <option value="" @if(empty($subscribe)) selected="selected" @endif>请选择技师</option>
               @if(!empty($subscribe))
                 @if(count($selectedTechnicians))
                    @foreach($selectedTechnicians as $k => $item)
                        <option value="{{ $item->id }}" @if(!empty($subscribe) && $item->id == $subscribe->technician_id) selected="selected" @endif>{{ $item->name }}</option>
                    @endforeach
                 @endif
             @endif
    </select>
</div>

<!-- Remark Field -->
<div class="form-group col-sm-8 col-lg-8">
    {!! Form::label('remark', '备注:') !!}
    {!! Form::textarea('remark', null, ['class' => 'form-control']) !!}
</div>

@if(!empty($subscribe))
<div class="form-group col-sm-8">
    <label for="status">状态</label>
    <select name="status" class="form-control">
                    @foreach($status as $k => $item)
                        <option value="{{ $item }}" @if(!empty($subscribe) && $item == $subscribe->status) selected="selected" @endif>{{ $item }}</option>
                    @endforeach
            
    </select>
</div>
@endif

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('subscribes.index') !!}" class="btn btn-default">返回</a>
</div>
