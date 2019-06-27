<script src="{{ asset('js/area.js') }}"></script>
<script>
 //_init_area();
/*
三级选择
 */
     $('#province').on('change', function(){
            var newParentID = $('#province').val();
             $('#district').hide();
            if (newParentID == 0) {
                $('#city').empty();
                $('#city').append("<option value='0'>请选择城市</option>");
                return;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/api/cities/getAjaxSelect/"+newParentID,
                type:"POST",
                success: function(data) {
                    if(data.code==0){
                    $('#city').empty();
                    $('#city').append("<option value='0'>请选择城市</option>");
                    $('#city').append(data.message);
                }else{
                    $('#city').empty();
                    $('#city').append("<option value='0'>请选择城市</option>");
                }
                },
                error: function(data) {
                  //提示失败消息
                    
                },
            });
        });

        $('#city').on('change', function(){
            var newParentID = $('#city').val();

            if (newParentID == 0) {
                $('#district').empty();
                $('#district').append("<option value='0'>请选择区域</option>");
                $('#district').show();
                return;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/api/cities/getAjaxSelect/"+newParentID,
                type:"POST",
                success: function(data) {
                    if(data.code==0){
                    $('#district').empty();
                    $('#district').append("<option value='0'>请选择区域</option>");
                    $('#district').append(data.message);
                    $('#district').show();
                }else{
                    $('#district').empty();
                    $('#district').append("<option value='0'>请选择区域</option>");
                    $('#district').show();
                }
                   
                },
                error: function(data) {
                  //提示失败消息
                    
                },
            });
        });
</script>