@section('scripts')

<script src="{{ asset('vendor/dropzone/dropzone.js') }}"></script>
<script type="text/javascript">
	     //template模板
      var previewTemplate='<div class="dz-preview dz-file-preview uploads_box"><img class="success_img" data-dz-thumbnail/><input type="hidden" name="post_images[]" value=""><span class="dz-progress"></span><div class="zhezhao" data-status="none"></div></div>';
      //上传的dom对象
      var progress_dom;
      var myDropzone = new Dropzone(document.body, {
        url:'/zcjy/ajax/uploads',
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        addRemoveLinks:false,
        maxFiles:6,
        previewTemplate: previewTemplate,
        autoQueue: true, 
        previewsContainer: "#success_image_box", 
        clickable: "#uploads_image" 
      });
      myDropzone.on("addedfile", function(file){
  	   $('#success_image_box').fadeIn(300);
        console.log(file);
        progress_dom=file.previewElement;
        console.log(progress_dom);
        $('.uploads_box').each(function(){
          console.log($(this).index());
         //有6张的时候隐藏
          if($(this).index()==5){
            $('#uploads_image').hide();
          }
          //一次上传大于6张中断并且删除
          if($(this).index()>=6){
             $(this).remove();
             return false;
          }
        });
      });
      //队列上传过程
      myDropzone.on("totaluploadprogress", function(progress) {
      	//添加过程进度
        progress=Math.round(progress);
        $(progress_dom).find('span').text(progress+'%');
      });
      //队列上传结束
      myDropzone.on("queuecomplete", function(progress) {
      	//上传结束去除数字
        $('#success_image_box').find('span').text('');
      });
      //上传成功触发的事件
      myDropzone.on("success",function(file,data){
          console.log('上传成功');
          var success_dom=file.previewElement;
          //给予input赋值
          $(success_dom).find('input').val(data.message.src); 
          //隐藏遮罩
          $(success_dom).find('.zhezhao').css('display', 'none');
          $(success_dom).find('.zhezhao').data('status', 'true');
          //替换图片
          $(success_dom).find('.success_img').attr('src',data.message.src);
          //添加删除按钮
          $(success_dom).append('<a class="remove" href="javascript:;" onclick="remove(this)">删除</a>');
      });


      function remove(obj){
      	$(obj).parent().remove();
      	//如果删除了再把按钮显示出来
        $('.uploads_box').each(function(){
          if($(this).index()<5){
            $('#uploads_image').fadeIn(500);
          }
        });
      }

     function delItem(obj, id) {
        $('#item_row_' + id).remove();
     }

</script>

@endsection