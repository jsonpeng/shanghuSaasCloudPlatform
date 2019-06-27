
@section('scripts')
    <script type="text/javascript">
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_minimal-blue'
        });
        $(document).ready(function() {
            $('.example-getting-started').multiselect();

            $('#datetimepicker_end').datepicker({
                format: "yyyy-mm-dd",
                language: "zh-CN",
                todayHighlight: true
            });
            $('#time_end').val($('#time_end').val().substring(0,10));

            $('#datetimepicker_begin').datepicker({
                format: "yyyy-mm-dd",
                language: "zh-CN",
                todayHighlight: true
            });
            $('#time_begin').val($('#time_begin').val().substring(0,10));

            //优惠券类型选择
            $('select[name=type]').on('change', function(e){
                if ($(this).val() == 1) {
                    //购物满送
                    $('input[name=base]').parent().show();
                } else {
                    $('input[name=base]').parent().hide();
                }
            });
        });
            
    </script>
@endsection