@section('scripts')
<script type="text/javascript">
    var years = 1;
    @if(!empty($chargePackage))
    //编辑时
    years = parseInt($('#packages_tbody').children('tr').last().children('td:eq(0)').find('input').val());
    @endif
    //选择套餐
  	$('select[name=name]').change(function(){
  		$('input[name=level]').val($(this).find('option:selected').index());
        if($(this).val() != ''){
          $('#packages_tbody').children('tr').children('td:eq(1)').find('input').val($(this).find('option:selected').data('price'));
          $('#packages_table').show(500);
        }
        else{
          $('#packages_table').hide(500);
        }
  	});
    //输入专享条目
    $('textarea[name=exclusive]').keypress(function(e) {  
          var rows=parseInt($(this).attr('rows'));
            // 回车键事件  
           if(e.which == 13) {  
                rows +=1;
           }  
           $(this).attr('rows',rows);
     });
     //添加更多组合套餐
     $('.add_package_prices').click(function(){
          if(years == 0){
            $('#packages_tbody').children('tr').first().show();
             ++years;
            return false;
          }
          $('#packages_tbody').append($('.tr_first_tem').prop("outerHTML"));
          var last_tr = $('#packages_tbody').children('tr').last();
          //每一次把上一级选择器的值拿出来
          years = parseInt(last_tr.prev().children('td:eq(0)').find('input').val()) + 1;
          last_tr.children('td:eq(0)').find('input').val(years);
     });
     //删除
     function del_package(obj){
          --years;
          if(years == 0){
             $(obj).parent().parent().hide();
             return false;
          }
          $(obj).parent().parent().remove();
     }
</script>
@endsection