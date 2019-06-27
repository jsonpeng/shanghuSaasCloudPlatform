@section('scripts')
    <script type="text/javascript">
        function permAddOrDel(obj,addordel){
            var perm_id=$(obj).parent().data('permid');
            var that=obj;
            if(addordel){
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
              $.ajax({
                  url:"/zcjy/ajax/perm/"+perm_id+"/add",
                  type:"POST",
                  success:function(data){
                    if(data.code==0){
                           layer.msg(data.message, {icon: 1});
                           $(that).parent().html('<span class="label label-success" onclick="permAddOrDel(this,false)">是</span>');
                    }else{
                           layer.msg(data.message, {icon: 5});
                    }   
                  }
              });
          }else{
                  $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
              $.ajax({
                  url:"/zcjy/ajax/perm/"+perm_id+"/del",
                  type:"POST",
                  success:function(data){
                    if(data.code==0){
                           layer.msg(data.message, {icon: 1});
                            $(that).parent().html('<span class="label label-danger" onclick="permAddOrDel(this,true)">否</span>');
                    }else{
                           layer.msg(data.message, {icon: 5});
                    }   
                  }
              });
          }
        }
    </script>
@endsection