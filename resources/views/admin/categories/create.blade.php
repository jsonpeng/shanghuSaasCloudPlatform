@extends('admin.layouts.app_shop')

@section('content')
    <section class="content-header">
        <h1>
            新建产品分类
        </h1>
    </section>
    <div class="content pdall0-xs">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'categories.store']) !!}

                        @include('admin.categories.fields', ['categories' => $categories, 'second_categories' => $second_categories, 'level01' => -1, 'level02' => -1, 'category' => null])
                        
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.imagemodel')

@endsection

{{-- @include('admin.categories.js') --}}
