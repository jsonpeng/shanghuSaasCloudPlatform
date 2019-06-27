@extends('admin.layouts.app')

@section('content')
<div class="container-fluid" style="padding: 30px 15px;">
    <div class="row">
        @include('headquarter.managers.left_bar')

        <div class="col-sm-9 col-lg-10">
            <section class="content-header">
                <h1>
                    创建{!! $input['type'] !!}
                </h1>
            </section>
            <div class="content">
                @include('adminlte-templates::common.errors')
                <div class="box box-primary form">

                    <div class="box-body">
                        <div class="row">
                            {!! Form::open(['route' => 'managers.store']) !!}

                                @include('headquarter.managers.fields')

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