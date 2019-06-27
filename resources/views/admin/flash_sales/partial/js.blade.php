<script type="text/javascript">

    $(document).ready(function() {
        //$('input[name=time_end]').attr('readonly','readonly');

        $('#datetimepicker_begin').datetimepicker({
            format: "yyyy-mm-dd hh:ii",
            language: "zh-CN",
            todayHighlight: true
        });

        $('#datetimepicker_end').datetimepicker({
            format: "yyyy-mm-dd hh:ii",
            language: "zh-CN",
            todayHighlight: true
        });

        // $('input[name=time_begin]').change(function(){
        //     var val=$(this).val();
        //     var dates=new Date(Date.parse(val));
        //     var hour=dates.getHours();
        //     var uom = null;
        //     if(hour%2){
        //         uom = new Date(dates-0+3600000);;
        //     }else{
        //         uom = new Date(dates-0+2*3600000);;
        //     }

        //     var year=uom.getFullYear();
        //     var month=uom.getMonth()+1;
        //     var day=uom.getDate();
        //     var hour=uom.getHours();

        //     if(month<10){
        //         month="0"+month;
        //     }
        //     if(day<10){
        //         day="0"+day;
        //     }
            
        //     if(hour<10){
        //         hour="0"+hour;
        //     }
        //     $('input[name=time_end]').val(year+'-'+month+'-'+day+' '+hour+':'+'00');
        // });

    });
</script>
