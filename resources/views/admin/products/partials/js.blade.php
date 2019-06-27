


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

        
        /**
         * 服务数量控制加减
         * @param  {[type]} obj    [description]
         * @param  {[type]} action [description]
         * @param  {[type]} type   [description]
         * @return {[type]}        [description]
         */
        function serviceNumControl(obj,action,type){
            var input = $(obj).parent().find('input');
            var val =input.val();
            //如果动作是减
            if(action == 'del'){
                 if(val > 1){
                    --val;
                 }
            }else{
                ++val;
            }
           input.val(val); 
        }

        /**
         * 服务input输入
         * @param  {[type]} obj [description]
         * @return {[type]}     [description]
         */
        function serviceInputControl(obj){
            obj.value=obj.value.replace(/[^\d.]/g,"");
            if(obj.value == 0 || obj.value == ''){
                obj.value =1;
            }
        }

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


    </script>
