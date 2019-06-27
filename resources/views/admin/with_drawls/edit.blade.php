@extends('admin.layouts.app')

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
                   {!! Form::model($withDrawl, ['route' => ['withDrawls.update', $withDrawl->id], 'method' => 'patch']) !!}

                        @include('admin.with_drawls.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection


@section('scripts')
<script type="text/javascript">
  $(function(){
          $('#datetimepicker').datetimepicker({
            format: "yyyy-mm-dd hh:ii",
            language: "zh-CN",
            todayHighlight: true
        });
  });
</script>
@endsection
