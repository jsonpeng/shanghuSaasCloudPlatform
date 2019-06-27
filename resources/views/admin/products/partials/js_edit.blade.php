
@section('scripts')
    <script type="text/javascript">
        tinymce.init({
            selector: 'textarea.intro',
            height: 500,
            theme: 'modern',
            language: 'zh_CN',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help responsivefilemanager'
            ],
            toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | responsivefilemanager',
            toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
            image_advtab: true,
            external_filemanager_path:"/filemanager/",
            filemanager_title:"图片" ,
            external_plugins: { "filemanager" : "/vendor/tinymce/plugins/responsivefilemanager/plugin.min.js"},
            templates: [
                { title: 'Test template 1', content: 'Test 1' },
                { title: 'Test template 2', content: 'Test 2' }
            ],
            content_css: [
                //'//www.tinymce.com/css/codepen.min.css'
            ]
        });


        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_minimal-blue'
        });
        $(document).ready(function() {
            $('.example-getting-started').multiselect();

            $('#datetimepicker_start').datetimepicker({
                format: 'yyyy-mm-dd hh:ii',
                language: 'zh_CN'

            });
            $('#datetimepicker_end').datetimepicker({
                format: 'yyyy-mm-dd hh:ii'
            });
        });

        $('.level01').on('change', function(){

            $('select.level03').empty();
            $('select.level03').append("<option value='0'>请选择分类</option>");

            var newParentID = $('select.level01').val();
            if (newParentID == 0) {
                $('select.level02').empty();
                $('select.level02').append("<option value='0'>请选择分类</option>");
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
                    $('select.level02').append("<option value='0'>请选择分类</option>");
                    for (var i = data.length - 1; i >= 0; i--) {
                        $('select.level02').append("<option value='"+data[i].id+"'>"+data[i].name+"</option>");
                    }
                },
                error: function(data) {
                  //提示失败消息
                    
                },
            });
        })

        $('.level02').on('change', function(){

            var newParentID = $('select.level02').val();
            if (newParentID == 0) {
                $('select.level03').empty();
                $('select.level03').append("<option value='0'>请选择分类</option>");
                return;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/zcjy/childCategories/"+$('select.level02').val(),
                type:"GET",
                data:'',
                success: function(data) {
                    $('select.level03').empty();
                    $('select.level03').append("<option value='0'>请选择分类</option>");
                    for (var i = data.length - 1; i >= 0; i--) {
                        $('select.level03').append("<option value='"+data[i].id+"'>"+data[i].name+"</option>");
                    }
                },
                error: function(data) {
                  //提示失败消息
                    
                },
            });
        })

        function productimage(id) {
            $('iframe#image').attr('src', '/filemanager/dialog.php?type=1&field_id=' + id);
            console.log(id);
        }

   

        function deletePic(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/zcjy/productImages/" + id,
                type:"POST",
                data:'_method=DELETE',
                success: function(data) {
                    //提示成功消息
                    console.log(data);
                    if (data.code == 0) {
                        console.log('yes');
                        $('#product_image_' + id).remove();
                    }
                },
                error: function(data) {
                    //提示失败消息

                },
            });
        }

        // 商品模型切换时 ajax 调用  返回不同的属性输入框
        $("#spec_type").change(function(){        
            var product_id = {{$product->id}};
            var spec_type = $(this).val();
                $.ajax({
                    type:'GET',
                    data:{product_id:product_id,spec_type:spec_type}, 
                    url:"/zcjy/products/ajaxGetSpecSelect",
                    success:function(data){                            
                       $("#ajax_spec_data").html('')
                       $("#ajax_spec_data").append(data);
                        ajaxGetSpecInput();  // 触发完  马上触发 规格输入框
                    }
                });           
                //商品类型切换时 ajax 调用  返回不同的属性输入框     
                $.ajax({
                     type:'GET',
                     data:{product_id:product_id,type_id:spec_type}, 
                     url:"/zcjy/products/ajaxGetAttrInput",
                     success:function(data){                            
                        $("#goods_attr_table tr:gt(0)").remove()
                        $("#goods_attr_table").append(data);
                     }        
               });
        });
        // 触发商品规格
        $("#spec_type").trigger('change'); 

        function saveTypeForm(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/zcjy/products/ajaxSaveTypeAttr/{{ $product->id }}",
                type:"POST",
                data: $('#typeattrForm').serialize(),
                success: function(data) {
                    //提示成功消息
                    if (data.code == 0) {
                        layer.msg(data.message, {icon: 1});
                      }else{
                        layer.msg(data.message, {icon: 5});
                      }
                },
                error: function(data) {
                    //提示失败消息

                },
            });
        }

        //重新刷新时整理表单
        function dealWithEmptyForm(){
             $("#spec_input_tab >tbody >tr:nth-child(1)").nextAll().each(function(){
                var price_input=$(this).children('td:nth-child(3)').children('input').val();
                //console.log(price_input);
               if(price_input==0){
                    $(this).children('td:nth-child(3)').children('input').parent().parent().remove();
               }
             });
        }

        setTimeout(function(){
            dealWithEmptyForm();
        },1000);
    </script>
@endsection