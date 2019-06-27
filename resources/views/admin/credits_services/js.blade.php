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
	    //选择兑换类型
	    $('select[name=type]').change(function(){
	    	var val = $(this).val();
	    	if(val == '礼物' || val == ''){
	    		$('#services_items').find('.items').find('a').trigger('click');
	    	}else if(val == '服务'){
	    		addServiceMenuFunc(2);
	    		console.log('服务');
	    	}
	    });
</script>
@endsection