<div class="col-sm-12">
    <div class="row">
        <!-- Name Field -->
        <div class="form-group col-sm-12">
      
             <label for="name">显示名称<span class="bitian">(必填):</span></label>
            {!! Form::text('display_name', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Sort Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('model', '模块:') !!}
                    <select class="form-control" name="model">
                        <option value="系统">系统</option>
                        <option value="商城" >商城</option>
                        <option value="促销">促销</option>
                        <option value="分销">分销</option>
                    </select>
        </div>


     <div class="form-group col-sm-12">
        <label for="order_delivery">所属组</label>
        <select class="form-control" name="tid">
            @foreach($group as $item)
            <option value="{!! $item['tid'] !!}">{!! $item['word'] !!}</option>
            @endforeach
            <option value="new">新建</option>
        </select>
    </div>

        <div class="form-group col-sm-12">
              {!! Form::label('name', '路由:') !!}
             {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-sm-12">
            {!! Form::label('model', '类型:') !!}
                    <select class="form-control" name="description">
                        <option value="所有页面和操作">所有页面和操作</option>
                        <option value="页面" >页面</option>
                        <option value="操作">操作</option>
                    </select>
        </div>
    
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
{!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
<a href="{!! route('permissions.index') !!}" class="btn btn-default">取消</a>
</div>
</div>
</div>