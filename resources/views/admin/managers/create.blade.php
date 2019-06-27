@extends('admin.layouts.app_shop')

@section('content')
<div class="container-fluid" style="padding: 30px 15px;">
    <div class="row">

        <div class="col-sm-9 col-lg-10">
            <section class="content-header">
                <h1>
                    创建商户
                </h1>
            </section>
            <div class="content">
                @include('adminlte-templates::common.errors')
                <div class="box box-primary form">

                    <div class="box-body">
                        <div class="row">
                            {!! Form::open(['route' => 'shopBranchManagers.store']) !!}

                                @include('admin.managers.fields')

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
        $('input[type=checkbox]').click(function(){
            var that = this;
            $('input[type=checkbox]').each(function(){
                    $(this).removeAttr('checked');
                    $(that).prop('checked',true);
            });
        });
    </script>
@endsection