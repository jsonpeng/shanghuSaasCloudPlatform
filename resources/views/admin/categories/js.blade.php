@section('scripts')
    <script>
        var category_id={!! empty($category)?'""':$category->id !!};
        $('.level01').trigger('change');
    	$('.level01').on('change', function(){
    		var newParentID = $('select.level01').val();
            var disabled='';
    		if (newParentID == 0) {
    			$('select.level02').empty();
                $('select.level02').append("<option value='0'>无分类</option>");
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
                  	$('select.level02').append("<option value='0'>无分类</option>");
            		for (var i = data.length - 1; i >= 0; i--) {
                        if(parseInt(category_id)==parseInt(data[i].id)){
                            disabled='disabled';
                        }
            			$('select.level02').append("<option value='"+data[i].id+"' "+disabled+">"+data[i].name+"</option>");
                    }
            		
                },
                error: function(data) {
                  //提示失败消息
                	
                },
            });
    	});
        $('.level01>option,.level02>option').each(function(){
             if(parseInt($(this).attr('value'))==parseInt(category_id)){
                $(this).attr('disabled','disabled');
             }
        });
        /*
        $('.level02>option').each(function(){
                if(!$(this).attr('selected')=='selected'){
                $(this).remove();
                }
        });
        */
        @if($disable)
        $('.level01>option,.level02>option').each(function(){
                $(this).attr('disabled','disabled');
        });
        @endif
    </script>
@endsection