@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            用户角色
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('admin.roles.show_fields', ['permissions' => $permissions])
                    <a href="{!! route('roles.index') !!}" class="btn btn-default">返回 </a>
                </div>
            </div>
        </div>
    </div>
@endsection
