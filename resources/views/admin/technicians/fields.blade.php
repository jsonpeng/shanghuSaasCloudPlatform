<!-- Name Field -->
<div class="form-group col-sm-8">
    <label for="name">技师名称<span class="bitian">(必填):</span></label>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-8">
    {!! Form::label('image', '技师图片:') !!}
    {!! Form::text('image', null, ['class' => 'form-control','id' => 'image']) !!}
       <div class="input-append">
            <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image')">选择图片</a>
            <img src="@if(!empty($technician)) {{ $technician->image }} @endif" style="max-width: 100%; max-height: 150px; display: block;">
      </div>
</div>

<!-- Intro Field -->
<div class="form-group col-sm-8 col-lg-8">
    {!! Form::label('intro', '技师介绍:') !!}
    {!! Form::textarea('intro', null, ['class' => 'form-control']) !!}
</div>


<div class="form-group col-sm-9">
    <label for="job">技师职务</label>
    {!! Form::text('job', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-4">
    <label for="sentiment">人气数</label>
    {!! Form::text('sentiment', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-4">
    <label for="give_like">点赞数</label>
    {!! Form::text('give_like', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-4">
    <label for="forward">转发数</label>
    {!! Form::text('forward', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    <label for="mobile">手机号</label>
    {!! Form::text('mobile', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    <label for="weixin">微信</label>
    {!! Form::text('weixin', null, ['class' => 'form-control']) !!}
</div>


<!-- Work Day Field -->
<div class="form-group col-sm-8">
    <label for="workday">工作日<span class="bitian">(必选):</span></label>

        <?php $workdays_all = technicianWorkDay();?>
  {{--       @foreach ($workday  as $k => $v)
              <option value="{!! $k !!}" @if(!empty($technician) && $technician->work_day == $k) selected="selected" @endif>{!! $v !!}</option>
        @endforeach --}}
              <div class="row">
                    @foreach($workdays_all as $k => $v)
                        <div class="col-sm-3">
                            <label>
                                {!! Form::checkbox('workday[]', $k, in_array($k , $workdays), ['class' => 'select_workday']) !!}
                                    {!! $v !!}
                            </label>
                        </br>
                        </div>
                    @endforeach
            </div>
 
</div>

<div class="form-group  col-sm-8" style="overflow: hidden;">
            <label for="services">选择服务<span class="bitian">(必选):</span></label>
               <button class="btn btn-primary btn-sm daterange " type="button" title="选择服务" onclick="addServiceMenuFunc(1)"> <i class="fa fa-plus"></i>
            </button>

</div>

<div id="services_items" class="form-group col-sm-12" style="display:{!! empty($technician) ?'none':'block' !!};margin-top:20px;">
        <div class="box-header with-border">
            <h3 class="box-title">关联服务信息</h3>
        </div>
        <div  class="box-body" >
            <div class="row" style="background-color: #edfbf8;">
                <div class="col-md-6 col-xs-6">服务名称</div>
          
                <div class="col-md-6 col-xs-6">操作</div>
            </div>
            @if (!empty($technician))
                 @if(count($services)) 
                     @foreach($services as $item)
                        <div class="items row" style="border-bottom: 1px solid #f4f4f4" data-id="{!! $item->id !!}">
                                <div class="col-md-6 col-xs-6">
                                    {{ $item->name }}
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <div class='btn-group' id="item_" style="padding: 8px;">
                                        <a href="javascript:;" class='btn btn-danger btn-xs'  onclick="delServiceItem(this)"> <i class="glyphicon glyphicon-trash" title="确认"></i>
                                        </a>
                                    </div>
                                </div>
                                <input type="hidden" name="services_id[]" value="{{ $item->id }}" />
                        </div>
                     @endforeach
                 @endif
            @endif
        </div>
</div>

<div id="services_items_table" style="display:none;"></div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('technicians.index') !!}" class="btn btn-default">返回</a>
</div>
