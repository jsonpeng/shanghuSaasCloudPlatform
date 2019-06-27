<div class="col-sm-12">
    <div class="row">
        <!-- Name Field -->
        <div class="form-group col-sm-6">
             <label for="name">角色名称<span class="bitian">(必填):</span></label>
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>

        <!-- Sort Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('description', '描述:') !!}
            {!! Form::text('description', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-sm-12">
            <!-- permissions Id Field -->
            <div class="row ml0mr0">
               <h4>系统设置&nbsp;&nbsp;<input type="checkbox" class="role_all_set" /></h4>
                @foreach ($permissions as $permission)
                @if($permission->model=='系统')
                <?php $autoGroupWord=autoMatchRoleGroupNameByTid($permission->tid,false);?>
                <div class="box box-solid" data-tid="{!!  $permission->tid !!}">
                    <div class="box-header">
    
                            <h3 class="box-title">
                                {!! $autoGroupWord !!}
                            </h3>
                    </div>
             <div class="box-body">
                <div class="form-group col-sm-12" id="checkbox_content">
                    <label>
                        {!! Form::checkbox('permissions[]', $permission->id, in_array($permission->id, $selectedPermissions), ['class' => 'field minimal']) !!}
                        {!! $permission->display_name !!}
                    </label>
              
                </div>
            </div>
            </div>
              @endif
              @endforeach
            </div>

        <div class="row ml0mr0">
            <h4>商城设置&nbsp;&nbsp;<input type="checkbox" class="role_all_set" /></h4>
            @foreach ($permissions as $permission)
              @if($permission->model=='商城')
               <?php $autoGroupWord=autoMatchRoleGroupNameByTid($permission->tid,false);?>
               <div class="box box-solid" data-tid="{!!  $permission->tid !!}">
                    <div class="box-header">
    
                            <h3 class="box-title">
                                {!! $autoGroupWord !!}
                            </h3>
                    </div>
             <div class="box-body">
                <div class="form-group col-sm-12" id="checkbox_content">
                    <label>
                        {!! Form::checkbox('permissions[]', $permission->id, in_array($permission->id, $selectedPermissions), ['class' => 'field minimal']) !!}
                        {!! $permission->display_name !!}
                    </label>
              
                </div>
            </div>
            </div>
                @endif
              @endforeach
        </div>

    <div class="row ml0mr0">
        <h4>促销设置&nbsp;&nbsp;<input type="checkbox" class="role_all_set" /></h4>
        @foreach ($permissions as $permission)
           @if($permission->model=='促销')
                <?php $autoGroupWord=autoMatchRoleGroupNameByTid($permission->tid,false);?>
               <div class="box box-solid" data-tid="{!!  $permission->tid !!}">
                    <div class="box-header">
    
                            <h3 class="box-title">
                                {!! $autoGroupWord !!}
                            </h3>
                    </div>
             <div class="box-body">
                <div class="form-group col-sm-12" id="checkbox_content">
                    <label>
                        {!! Form::checkbox('permissions[]', $permission->id, in_array($permission->id, $selectedPermissions), ['class' => 'field minimal']) !!}
                        {!! $permission->display_name !!}
                    </label>
              
                </div>
            </div>
            </div>
                @endif
         @endforeach
    </div>

        <div class="row ml0mr0">
        <h4>分销设置&nbsp;&nbsp;<input type="checkbox" class="role_all_set" /></h4>
        @foreach ($permissions as $permission)
           @if($permission->model=='分销')
                <?php $autoGroupWord=autoMatchRoleGroupNameByTid($permission->tid,false);?>
               <!--div class="box box-solid"-->
                    <!--div class="box-header">
                            <i class="fa fa-{!! $permission->icon !!}"></i>
                            <h3 class="box-title">
                                {!! $autoGroupWord !!}
                            </h3>
                    </div-->
                    <div class="box-header with-border" data-tid="{!!  $permission->tid !!}">
                        <h3 class="box-title">{!! $autoGroupWord !!}</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group col-sm-12" id="checkbox_content">
                            <label>
                                {!! Form::checkbox('permissions[]', $permission->id, in_array($permission->id, $selectedPermissions), ['class' => 'field minimal']) !!}
                                {!! $permission->display_name !!}
                            </label>
                      
                        </div>
                    </div>
                <!--/div-->
                @endif
         @endforeach
    </div>

</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
{!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
<a href="{!! route('roles.index') !!}" class="btn btn-default">取消</a>
</div>
</div>
</div>