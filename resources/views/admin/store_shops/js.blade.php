@section('scripts')
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=usHzWa4rzd22DLO58GmUHUGTwgFrKyW5"></script>
<script>
        function openMap(type=''){
            var name =type==''?'address':type;
            var address=$('input[name='+name+']').val();
            var url="/zcjy/settings/map?address="+address;
                if($(window).width()<479){
                        layer.open({
                            type: 2,
                            title:'请选择详细地址',
                            shadeClose: true,
                            shade: 0.8,
                            area: ['100%', '100%'],
                            content: url, 
                        });
                }else{
                     layer.open({
                        type: 2,
                        title:'请选择详细地址',
                        shadeClose: true,
                        shade: 0.8,
                        area:['60%', '680px'],
                        content: url, 
                    });
                }
        }

        function call_back_by_map(address,jindu,weidu){
            if(address != '' && address != null){
                $('input[name=detail],input[name=address]').val(address);
            }
            $('input[name=weidu]').val(weidu);
            $('input[name=jindu]').val(jindu);
            layer.closeAll();
        }
        $('input[name=address]').keyup(function(){
            var val = $(this).val();
            if(val != ''){

                controlMap(val);
            }
        });
</script>
<!--根据地址索引地图标点-->
<script type="text/javascript">
    function showInfo(e){
          // e.point.lng;  
          // e.point.lat;  
            myGeo.getLocation(e.point, function (rs) {  
            var addComp = rs.addressComponents;  
            var address = addComp.province + addComp.city + addComp.district + addComp.street + addComp.streetNumber;  
            if (confirm("确定选择地址是" + address + "?")) {  
                 javascript:window.parent.call_back_by_map(address,e.point.lng,e.point.lat);
            }  
        });  
          addMarker(e.point);  
    }

    //地图上标注  
    function addMarker(point) {  
        var marker = new BMap.Marker(point);  
        markersArray.push(marker);  
        clearOverlays();  
        map.addOverlay(marker);  
    } 

    //清除标识  
    function clearOverlays() {  
        if (markersArray) {  
            for (i in markersArray) {  
                map.removeOverlay(markersArray[i])  
            }  
        }  
    }
    var map = new BMap.Map("allmap");
    map.setMapStyle({style:'normal'});
    //var point = new BMap.Point(114.329303,30.475501);
    //map.centerAndZoom(point,12);
    // 创建地址解析器实例
    var myGeo = new BMap.Geocoder();
    // 百度地图API功能
    var markersArray = [];  
    function controlMap(address){ 
      
        // 将地址解析结果显示在地图上,并调整地图视野
        myGeo.getPoint(address, function(point){
            if (point) {
                $('.map').show(500);
                map.centerAndZoom(point, 16);
                clearOverlays();
                map.addOverlay(new BMap.Marker(point));
                //map.addControl(new BMap.NavigationControl());               // 添加平移缩放控件
                //map.addControl(new BMap.ScaleControl());                    // 添加比例尺控件
               // map.addControl(new BMap.OverviewMapControl());              //添加缩略地图控件
                map.enableScrollWheelZoom();  
                myGeo.getLocation(point, function (rs) {  
                var addComp = rs.addressComponents;  
                var address = addComp.province + addComp.city + addComp.district + addComp.street + addComp.streetNumber;  
               
                javascript:window.parent.call_back_by_map(null,point.lng,point.lat);
                 
            });                            //启用滚轮放大缩小
            }else{
                $('.map').hide(500);
                //alert("您选择地址没有解析到结果!");
            }
        });
        map.addEventListener("click", showInfo); 
    }   
</script>
@endsection