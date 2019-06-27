
@section('scripts')
    <script type="text/javascript">
        function printOrder(id) {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/zcjy/orders/" + id + '/print',
                type:"GET",
                data:'',
                success: function(data) {
                    //提示成功消息
                    data = JSON.parse(data);
                    if (data.ret == 0) {
                        layer.msg('操作成功');
                    } else {
                        layer.msg(data.msg);
                    }
                },
                error: function(data) {
                    //提示失败消息
                },
            });
        }

        $('#sendtime_start, #sendtime_end, #create_start, #create_end').datepicker({
            format: "yyyy-mm-dd",
            language: "zh-CN",
            todayHighlight: true
        });

        $('.managerBackAction').hide();
        function search() {
            window.location.href = "/zcjy/orders?"+$('#order_search').serialize();
        }
        /**
         * [report description]
         * @return {[type]} [description]
         */
        function report(){
            console.log('report');
            window.location.href = "/zcjy/orders/reportMany?"+$('#order_search').serialize();
        }
    </script>
@endsection