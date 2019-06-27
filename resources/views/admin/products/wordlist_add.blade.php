@extends('admin.layouts.app_shop')

@section('content')
    <section class="content-header mb10-xs">
        <h1>
            添加保障信息
        </h1>
    </section>
<div class="content pdall0-xs">
    @include('adminlte-templates::common.errors')
    <div class="box box-primary form">

        <div class="box-body">
            <div class="row">
                {!! Form::open(['route' => 'wordlist.store']) !!}
                <div class="form-group col-sm-12">
                    <label for="name">名称<span class="bitian">(必填):</span></label>
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>
                    
                <div class="form-group col-sm-12">
                        {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
                        <a href="{!! route('wordlist.index') !!}" class="btn btn-default">取消</a>
                </div>
                 {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection