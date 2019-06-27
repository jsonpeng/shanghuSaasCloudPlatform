<div class="form-group col-sm-8"> 

    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">套餐详情</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        <div class="form-group">
            <label for="name">套餐名称<span class="bitian">(必选):</span></label>
            <select name="name" class="form-control">
                <option value="">请选择套餐</option>

                @foreach($packages as $key => $item)
                    <option value="{{ $key }}" @if(!empty($chargePackage) && $key == $chargePackage->name) selected="selected" @endif data-price="{{ $item }}">{{ $key }}</option>
                @endforeach
            </select>
        </div>

{!! Form::hidden('level', null, ['class' => 'form-control']) !!}

<div class="form-group ">
    {!! Form::label('image', '套餐图片:') !!}
    {!! Form::text('image', null, ['class' => 'form-control','id' => 'image']) !!}
    <div class="input-append">
        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image')">选择图片</a>
        <img src="@if(!empty($chargePackage)) {{ $chargePackage->image }} @endif" style="max-width: 100%; max-height: 150px; display: block;">
    </div>
</div>


<div class="form-group ">
    <label for="canuse_shop_num">适用店铺数量<span class="bitian">(必填):</span></label>
    {!! Form::number('canuse_shop_num', null, ['class' => 'form-control','placeholder'=>'请输入适用店铺数量']) !!}
</div>

<div class="form-group ">
    <label for="exclusive">专享条目(多个用回车分开)</label>
    @if(empty($chargePackage))
    {!! Form::textarea('exclusive', null, ['class' => 'form-control','placeholder'=>'请输入专享条目,多个用回车分开','rows'=>'1']) !!}
    @else
    {!! Form::textarea('exclusive', null, ['class' => 'form-control','placeholder'=>'请输入专享条目,多个用回车分开','rows'=>count(getList($chargePackage->exclusive))]) !!}
    @endif
</div>



<div class="form-group"  id="packages_table" @if(!empty($chargePackage)) style="display: {!! count($chargePackage->prices()->get())?'block':'none' !!};" @else style="display: none;" @endif>

<a href="javascript:;" class="add_package_prices" >添加更多组合套餐</a>
<table class="table table-responsive" id="freight_tems-table">
    <thead>
        <th>年数(年)</th>
        <th>金额(元)</th>
        <th>原价(元)</th>
        <th>一级代理商分润</th>
        <th>二级代理商分润</th>
        <th>操作</th>
    </thead>
    <tbody id="packages_tbody">

         @if(!empty($chargePackage))
         {{-- 编辑时 --}}
            @foreach ($prices as $item)
                  <tr class="tr_first_tem">
                        <td>
                            <input name="years[]" value="{{ $item->years }}" placeholder="年" class="form-control"  readonly="readonly" />
                        </td>
                        <td>
                            <input name="prices[]" value="{{ $item->price }}" placeholder="金额(元)" class="form-control" />
                        </td>
                        <td>
                            <input name="origin_prices[]" value="{{ $item->origin_price }}" placeholder="原价(元)" class="form-control" />
                        </td>
                        <td>
                            <input name="bonus_ones[]" value="{{ $item->bonus_one }}" placeholder="一级代理商分润(元)" class="form-control" />
                        </td>
                        <td>
                            <input name="bonus_twos[]" value="{{ $item->bonus_two }}" placeholder="二级代理商分润(元)" class="form-control" />
                        </td>
                        <td>
                            <button class="btn btn-danger btn-xs package_del" type="button" onclick="del_package(this)"><i class="glyphicon glyphicon-trash"></i>删除</button>
                        </td>
                 </tr>
            @endforeach
         @else
         {{-- 初次创建时 --}}
              <tr class="tr_first_tem">
                    <td>
                        <input name="years[]" value="1" placeholder="年" class="form-control"  readonly="readonly" />
                    </td>
                    <td>
                        <input name="prices[]" value="" placeholder="金额(元)" class="form-control" />
                    </td>
                    <td>
                        <input name="origin_prices[]" value="" placeholder="原价(元)" class="form-control" />
                    </td>
                    <td>
                        <input name="bonus_ones[]" value="" placeholder="一级代理商分润(元)" class="form-control" />
                    </td>
                    <td>
                        <input name="bonus_twos[]" value="" placeholder="二级代理商分润(元)" class="form-control" />
                    </td>
                    <td>
                        <button class="btn btn-danger btn-xs package_del" type="button" onclick="del_package(this)"><i class="glyphicon glyphicon-trash"></i>删除</button>
                    </td>
              </tr>
        @endif
    </tbody>
</table>
</div>

</div>
</div>
</div>

<div class="form-group col-sm-4">
    <div class="box box-solid">
    <div class="box-body">
        <div class="form-group">
            {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
            <a href="{!! route('chargePackages.index') !!}" class="btn btn-default">返回</a>
        </div>
        <div class="form-group ">
             {!! Form::label('words', '套餐条目:') !!}
                <div class="row" >
                    @if(count($wordlist))
                        @foreach ($wordlist as $item)
                            <div class="col-sm-8">
                                <label>
                                    {!! Form::checkbox('words[]', $item->id, in_array($item->id, $selectedWords)) !!}
                                        {!! $item->name !!}
                                </label>
                            </br>
                            </div>
                        @endforeach
                    @else
                    <a class="col-sm-8" href="{!! route('wordlist.create') !!}">添加套餐条目</a>
                    @endif
                </div>
        </div>
       
     </div>
    </div>
</div>



