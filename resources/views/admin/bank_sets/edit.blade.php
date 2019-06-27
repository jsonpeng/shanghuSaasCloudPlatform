@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            编辑银行卡
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary form">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($bankSets, ['route' => ['bankSets.update', $bankSets->id], 'method' => 'patch']) !!}

                        @include('admin.bank_sets.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection

@include('admin.partial.imagemodel')