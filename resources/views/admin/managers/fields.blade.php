<!-- Name Field -->
<div class="form-group col-sm-12">
    <label for="nickname">名称<span class="bitian">(必填):</span></label>
    {!! Form::text('nickname', null, ['class' => 'form-control']) !!}
</div>



<!-- email Field -->
<div class="form-group col-sm-12">
    <label for="mobile">手机号<span class="bitian">(必填):</span></label>
    {!! Form::text('mobile', null, ['class' => 'form-control']) !!}
</div>

<!-- password Field -->

<div class="form-group col-sm-12">
    <label for="password">密码<span class="bitian">(必填):</span></label>
    {!! Form::text('password', '', ['class' => 'form-control']) !!}
</div>


<div class="form-group col-sm-12" style="overflow: hidden;">
    <label for="name">管理店铺<span class="bitian">(必选):</span></label>
    @if(count($shops))
        @foreach ($shops as $shop)
            <div style="margin-right: 20px;">
                <label>
                    {!! Form::checkbox('shops[]', $shop->id, in_array($shop->id, $selectedShops), ['class' => 'select_shop']) !!}
                        {!! $shop->name !!}
                </label>
            </br>
            </div>
        @endforeach
    @else
        <a href="{!! route('storeShops.create') !!}">请先创建店铺</a>
    @endif
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('shopBranchManagers.index') !!}" class="btn btn-default">取消</a>
</div>
