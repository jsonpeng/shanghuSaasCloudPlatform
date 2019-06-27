@section('scripts')
<script>     
    $('select[name=time_type]').on('change', function(e){
        if ($(this).val() == 0) {
            $('input[name=expire_days]').parent().hide();
            $('#datetimepicker_begin').parent().show(500);
            $('#datetimepicker_end').parent().show(500);
        } else {
            $('input[name=expire_days]').parent().show(500);
            $('#datetimepicker_begin').parent().hide();
            $('#datetimepicker_end').parent().hide();
        }
    });
    $('#datetimepicker_begin').datepicker({
        format: "yyyy-mm-dd",
        language: "zh-CN",
        todayHighlight: true
    });
    $('#datetimepicker_end').datepicker({
        format: "yyyy-mm-dd",
        language: "zh-CN",
        todayHighlight: true
    });
</script>
@endsection