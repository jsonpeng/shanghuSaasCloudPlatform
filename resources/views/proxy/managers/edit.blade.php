@extends('admin.layouts.app')

@section('content')
<div class="container-fluid" style="padding: 30px 15px;">
    <div class="row">
  

        <div class="col-sm-9 col-lg-10">
          <section class="content-header">
              <h1>
                  编辑{{ $input['type'] }}信息
              </h1>
         </section>
         <div class="content">
             @include('adminlte-templates::common.errors')
             <div class="box box-primary form">
                 <div class="box-body">
                     <div class="row">
                         {!! Form::model($manager, ['route' => ['shopManagers.update', $manager->id], 'method' => 'patch']) !!}
                           {{--    {!! Form::hidden('manager_id', $manager->id) !!}  --}}

                              @include('proxy.managers.fields')

                         {!! Form::close() !!}
                     </div>
                 </div>
             </div>
         </div>
      </div>
     </div>
 </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_minimal-blue'
        });
        $('#password').attr('type','password');
    </script>
@endsection