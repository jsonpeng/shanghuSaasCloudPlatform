@extends('admin.layouts.app_promp')

@section('content')
<section class="content-header mb10-xs">
  <h1>编辑团购</h1>
</section>
<div class="content pdall0-xs">
  @include('adminlte-templates::common.errors')
  <div class="box box-primary form mb10-xs">
    <div class="box-body">
      <div class="row">
        {!! Form::model($teamSale, ['route' => ['teamSales.update', $teamSale->id], 'method' => 'patch']) !!}

                        @include('admin.team_sales.fields')

                   {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
@endsection



@include('admin.partials.imagemodel')

@section('scripts')
<script type="text/javascript">
$(function(){
  $('#type').on('change', function(){
        var val=$(this).val();
        console.log(val);
        switch(val){
            case "0":
            $('#team_leader_bonus,#team_lottery_number').hide();
            break;
            case "1":
            $('#team_leader_bonus').show();
            $('#team_lottery_number').hide();
            break;
            case "2":
            $('#team_leader_bonus').hide();
            $('#team_lottery_number').show();
            break;
        }
  });
});
</script>
@endsection