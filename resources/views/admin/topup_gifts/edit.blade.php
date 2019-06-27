@extends('admin.layouts.app_shop')

@section('content')
    <section class="content-header">
        <h1>
            编辑
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($topupGifts, ['route' => ['topupGifts.update', $topupGifts->id], 'method' => 'patch']) !!}

                        @include('admin.topup_gifts.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection