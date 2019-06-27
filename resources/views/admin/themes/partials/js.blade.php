
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
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
            ],
            toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
            image_advtab: true,
            templates: [
                { title: 'Test template 1', content: 'Test 1' },
                { title: 'Test template 2', content: 'Test 2' }
            ],
            content_css: [
                //'//www.tinymce.com/css/codepen.min.css'
            ]
        });

        tinymce.init({
            selector: 'textarea.paras',
            height: 200,
            theme: 'modern',
            language: 'zh_CN',
            /*
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
            ],
            */
           plugins: [
                'table textcolor colorpicker',
            ],
            toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            /*toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
            image_advtab: true,
            templates: [
                { title: 'Test template 1', content: 'Test 1' },
                { title: 'Test template 2', content: 'Test 2' }
            ],
            content_css: [
                '//www.tinymce.com/css/codepen.min.css'
            ]
            */
        });


        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_minimal-blue'
        });
        $(document).ready(function() {
            $('.example-getting-started').multiselect();

            $('#datetimepicker_start').datetimepicker({
                format: 'yyyy-mm-dd hh:ii:ss',
                language: 'zh_CN'

            });
            $('#datetimepicker_end').datetimepicker({
                format: 'yyyy-mm-dd hh:ii:ss'
            });
        });
    </script>
@endsection