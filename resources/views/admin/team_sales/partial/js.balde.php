<script type="text/javascript">
$(function(){

  $('select[name=type]').on('change', function(){
        var val=$(this).val();
        switch(val){
            case 0:
            $('input[name=bonus],input[name=lottery_count]').hide();
            break;
            case 1:
            $('input[name=bonus]').show();
            $('input[name=lottery_count]').hide();
            break;
            case 2:
            $('input[name=bonus]').hide();
            $('input[name=lottery_count]').show();
            break;
        }

  });

});
</script>