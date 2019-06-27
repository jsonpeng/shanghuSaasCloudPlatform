@section('css')
    <style type="text/css">
        .checkbox label, .radio label{
            padding-left: 0; margin-bottom: 20px;
        }
        .icheckbox_flat-green{
            margin-right: 10px;
        }
        .checkbox label.fb{
            font-weight: bold;
        }
        .radio{width: 10%;
                margin-left: 20px;}
        .box{border-top: none;}
        input[name="services_num[]"],input[name="services_price[]"]{
                max-width: 80px;
                text-align: center;
                margin-left: 5px;
                margin-right:5px;
        }
        #services_items > span{
            font-size: 24px;
        }
    </style>
@endsection