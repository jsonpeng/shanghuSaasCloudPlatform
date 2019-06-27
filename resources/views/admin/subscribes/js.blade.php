@section('scripts')
<script>
$(function(){
	    $('#datetimepicker_arrivetime').datetimepicker({
            format: "yyyy-mm-dd hh:ii",
            language: "zh-CN",
            todayHighlight: true
        });

        //门店选择
        $('select[name=shop_id]').change(function(){
        	var shop_id = $(this).val();
        	//先初始化select下
    		$('select[name=service_id]').html('<option value="">请选择服务</option>');
            $('select[name=technician_id]').html('<option value="">请选择技师</option>');
            
        	if(shop_id != ''){
        		$.zcjyRequest('/zcjy/ajax/get_services_by_shop/'+shop_id,function(res){
        			if(res){
        				var service_html = '';
        				for (var i = res.length-1; i >= 0 ; i--) {
        					service_html += '<option value="'+res[i]['id']+'" >'+res[i]['name']+'</option>';
        				}
        				$('select[name=service_id]').append(service_html);
        			}
        		});
        		$('.sevices_box').show(500);
        	}
        	else{

        		$('.sevices_box').hide(500);
        		$('.technician_box').hide(500);
        	}
        });

        //服务选择
        $('select[name=service_id]').change(function(){
        	var service_id = $(this).val();
        	//先初始化select下
    		$('select[name=technician_id]').html('<option value="">请选择技师</option>');
        	if(service_id != ''){
        		$.zcjyRequest('/zcjy/ajax/get_technicicans_by_service/'+service_id,function(res){
        			if(res){
        				var technician_html = '';
        				for (var i = res.length-1; i >= 0 ; i--) {
        					technician_html += '<option value="'+res[i]['id']+'" >'+res[i]['name']+'</option>';
        				}
        				$('select[name=technician_id]').append(technician_html);
        			}
        		});
        		$('.technician_box').show(500);
        	}
        	else{
        		$('.technician_box').hide(500);
        	}
        });
});
</script>
@endsection