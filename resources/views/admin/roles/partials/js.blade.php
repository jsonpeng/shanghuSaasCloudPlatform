@section('scripts')
    <script type="text/javascript">
    $('.role_all_set').click(function(){
    		var status=$(this).is(':checked');
    		console.log($(this).is(':checked'));
    		//return;
    		if(!status){
    				$(this).parent().parent().find('input[type=checkbox]').each(function(){
    						$(this).prop('checked',false);
    				});
    		}else{
    				$(this).parent().parent().find('input[type=checkbox]').each(function(){
    						$(this).prop('checked',true);
    				});
    		}
    });
    var tid_arr=[];
    var repeat=false;
    $('.box').each(function(){
            var tid=$(this).data('tid');
            tid_arr.push(tid);
    });

    setTimeout(function(){
        $('.box').each(function(){
            var tid=$(this).data('tid');
            if(in_array(tid,tid_arr) && in_array(tid,tid_arr,true)>1){
                var that=this;
                var next_tid=tid;
                //$(this).next().hide().empty();
             $(this).nextAll().each(function(){
                    if(next_tid==$(this).data('tid')){
                        $(that).find('#checkbox_content').append("&nbsp;&nbsp;"+$(this).find('#checkbox_content').html());
                        $(this).hide().empty();
                    }
             });
            }
    });
    },1000);
    </script>
@endsection