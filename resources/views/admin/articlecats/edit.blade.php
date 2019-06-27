@extends('admin.layouts.app')

@section('content')
<section class="content-header">
  <h1>编辑分类</h1>
</section>
<div class="content">
  @include('adminlte-templates::common.errors')
  <div class="box box-primary">
    <div class="box-body">
      <div class="row">
        {!! Form::model($category, ['route' => ['articlecats.update', $category->id], 'method' => 'patch']) !!}

                        @include('admin.articlecats.fields', ['category' => $category])

                   {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
@include('admin.partials.imagemodel')
@endsection