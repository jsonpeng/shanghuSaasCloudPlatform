
@section('scripts')
    <script type="text/javascript">
        var cat_show='{!! getSettingValueByKey('category_level') !!}';
        cat_show=parseInt(cat_show);

        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_minimal-blue'
        });
        $(document).ready(function() {

            if(cat_show==0){
                $("#range option[value=1]").remove();
            }

            if(cat_show==1){
                $('.level02,.level03').remove();
            }

            if(cat_show==2){
                $('.level03').remove();
            }

            $('.example-getting-started').multiselect();
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
            @if(!Request::is('zcjy/coupons'))
            $('#time_end').val($('#time_end').val().substring(0,10));
            $('#time_begin').val($('#time_begin').val().substring(0,10));
            @endif
            //优惠券类型选择
            $('select[name=type]').on('change', function(e){
                if ($(this).val() == '满减') {
                    $('input[name=discount]').parent().hide();
                    $('input[name=given]').parent().show();
                } else {
                    $('input[name=discount]').parent().show();
                    $('input[name=given]').parent().hide();
                }
            })

            //有效期类型选择
            $('select[name=time_type]').on('change', function(e){
                if ($(this).val() == 0) {
                    $('input[name=expire_days]').parent().hide();
                    $('#datetimepicker_begin').parent().show();
                    $('#datetimepicker_end').parent().show();
                } else {
                    $('input[name=expire_days]').parent().show();
                    $('#datetimepicker_begin').parent().hide();
                    $('#datetimepicker_end').parent().hide();
                }
            });

            @if(!Request::is('zcjy/coupons'))
            //适用范围
            $('select[name=range]').on('change', function(e){
                if ($(this).val() == 1) {
                    $('.category_select').show();
                    $('#product_items').hide();
                    $("#add_spec_product").val(0);

                }else if($(this).val() == 2){
                    $('.category_select').hide();
                       $('#product_items').show();
                     addProductMenuFunc(4);
                } else {
                    $('#product_items').hide();
                    $('.category_select').hide();
                    $("#add_spec_product").val(0);
                }
            })
            @endif

            $('.level01').on('change', function(){

            $('select.level03').empty();
            $('select.level03').append("<option value='0'>请选择分类</option>");

            var newParentID = $('select.level01').val();
            if (newParentID == 0) {
                $('select.level02').empty();
                $('select.level02').append("<option value='0'>请选择分类</option>");
                return;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/zcjy/childCategories/"+$('select.level01').val(),
                type:"GET",
                data:'',
                success: function(data) {
                    $('select.level02').empty();
                    $('select.level02').append("<option value='0'>请选择分类</option>");
                    for (var i = data.length - 1; i >= 0; i--) {
                        $('select.level02').append("<option value='"+data[i].id+"'>"+data[i].name+"</option>");
                    }
                },
                error: function(data) {
                  //提示失败消息
                    
                },
            });
        })

        $('.level02').on('change', function(){

            var newParentID = $('select.level02').val();
            if (newParentID == 0) {
                $('select.level03').empty();
                $('select.level03').append("<option value='0'>请选择分类</option>");
                return;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/zcjy/childCategories/"+$('select.level02').val(),
                type:"GET",
                data:'',
                success: function(data) {
                    $('select.level03').empty();
                    $('select.level03').append("<option value='0'>请选择分类</option>");
                    for (var i = data.length - 1; i >= 0; i--) {
                        $('select.level03').append("<option value='"+data[i].id+"'>"+data[i].name+"</option>");
                    }
                },
                error: function(data) {
                  //提示失败消息
                    
                },
            });
        })
    });
    </script>

    <script type="text/javascript">
     function delItem(obj, id) {
        $('#item_row_' + id).remove();
     }
    </script>
@endsection