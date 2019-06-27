<script type="text/javascript">

    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_minimal-blue'
    });
    $(document).ready(function() {
        $('.example-getting-started').multiselect();


        $('#datetimepicker_end').datetimepicker({
            format: "yyyy-mm-dd hh:ii",
            language: "zh-CN",
            todayHighlight: true
        });

        $('#datetimepicker_begin').datetimepicker({
            format: "yyyy-mm-dd hh:ii",
            language: "zh-CN",
            todayHighlight: true
        });

        $('#type').on('change', function(){
            var curVal = parseInt($(this).val());
            changeTip(curVal);
        })

        function changeTip(curVal) {
            switch (curVal){
                case 0:
                $('.changeText label').text('折扣');
                $('.changeText .help-block').text('请输入折扣(%)，85折就输入85， 7折就输入70');
                break;
                case 1:
                $('.changeText label').text('优惠金额');
                $('.changeText .help-block').text('请输入优惠金额，单位 元');
                break;
                case 2:
                $('.changeText label').text('固定金额出售');
                $('.changeText .help-block').text('请输入售价，单位 元');
                break;
            }
        }

        //更改文本提示
        changeTip( parseInt($('#type').val()) );   

    });




 function delItem(obj, id) {
    $('#item_row_' + id).remove();
 }


</script>
