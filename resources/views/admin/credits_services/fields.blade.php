<!-- Name Field -->
<div class="form-group col-sm-8">
    <label for="type">兑换标题<span class="bitian">(必填):</span></label>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-8">
    {!! Form::label('image', '显示图片:') !!}
    {!! Form::text('image', null, ['class' => 'form-control','id' => 'image']) !!}
    <div class="input-append">
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image')">选择图片</a>
        <img src="@if(!empty($creditsService)) {{ $creditsService->image }} @endif" style="max-width: 100%; max-height: 150px; display: block;">
    </div>
</div>

<!-- Content Field -->
<div class="form-group col-sm-8">
    {!! Form::label('content', '详情:') !!}
    {!! Form::textarea('content', null, ['class' => 'form-control intro']) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-8">
    <label for="type">兑换类型<span class="bitian">(必选):</span></label>
    <select name="type" class="form-control">
         <option value="">请选择兑换类型</option>
         <option value="礼物" @if(!empty($creditsService) && $creditsService->type == '礼物') selected="selected" @endif>兑换礼物</option>
         <option value="服务" @if(!empty($creditsService) && $creditsService->type == '服务') selected="selected" @endif>兑换服务</option>
    </select>
</div>

<!-- Service Id Field -->
{{-- <div class="form-group col-sm-8">
    {!! Form::label('service_id', '服务:') !!}
    {!! Form::text('service_id', null, ['class' => 'form-control']) !!}
</div> --}}

<div id="services_items" class="form-group col-sm-12" style="display:{!! empty($creditsService) || !empty($creditsService) && $creditsService->type == '礼物' ?'none':'block' !!};margin-top:20px;">
        <div class="box-header with-border">
            <h3 class="box-title">服务信息</h3>
        </div>
        <div  class="box-body" >
            <div class="row" style="background-color: #edfbf8;">
                <div class="col-md-6 col-xs-6">服务名称</div>
          
                <div class="col-md-6 col-xs-6">操作</div>
            </div>
            @if (!empty($creditsService))
                 @if(!empty($service)) 
                        <div class="items row" style="border-bottom: 1px solid #f4f4f4">
                                <div class="col-md-6 col-xs-6">
                                    {{ $service->name }}
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <div class='btn-group' id="item_" style="padding: 8px;">
                                        <a href="javascript:;" class='btn btn-danger btn-xs'  onclick="delServiceItem(this)"> <i class="glyphicon glyphicon-trash" title="确认"></i>
                                        </a>
                                    </div>
                                </div>
                                <input type="hidden" name="services_id[]" value="{{ $service->id }}" />
                        </div>
                 @endif
            @endif
        </div>
</div>

<div id="services_items_table" style="display:none;"></div>

<!-- Need Num Field -->
<div class="form-group col-sm-8">
    <label for="need_num">需要积分<span class="bitian">(必填):</span></label>
    {!! Form::text('need_num', null, ['class' => 'form-control']) !!}
</div>

<!-- Count Time Field -->
<div class="form-group col-sm-8">
    {!! Form::label('count_time', '兑换次数:') !!}
    {!! Form::text('count_time', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('creditsServices.index') !!}" class="btn btn-default">返回</a>
</div>
