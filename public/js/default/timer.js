var interval = 1000;
function ShowCountDown(end_time_detail,divname,type) 
{ 
    end_time_detail=end_time_detail.replace(/-/g, '/'); 
    var dates=new Date(Date.parse(end_time_detail));
    var year=dates.getFullYear();
    var month=dates.getMonth()+1;
    var day=dates.getDate();
    var hour=dates.getHours();
    var min=dates.getMinutes();
    var sec=dates.getSeconds();
    var now = new Date();
    var endDate = new Date(year, month-1, day,hour,min,sec); 
    var leftTime=endDate.getTime()-now.getTime(); 
    var leftsecond = parseInt(leftTime/1000); 

    if(leftsecond<=0){
     $(divname).html('已过期');
      return false;
    }
    var day1=Math.floor(leftsecond/(60*60*24)); 
    var hour=Math.floor((leftsecond-day1*24*60*60)/3600); 
    var minute=Math.floor((leftsecond-day1*24*60*60-hour*3600)/60); 
    var second=Math.floor(leftsecond-day1*24*60*60-hour*3600-minute*60); 

    //"距离"+year+"年"+month+"月"+day+"日还有："+day1+"天"+hour+"小时"+minute+"分"+second+"秒"; 
    if(hour<10){
        hour="0"+hour;
    }
    if(minute<10){
        minute="0"+minute;
    }
    if(second<10){
        second="0"+second;
    }

    if(type=="flashsale_index"){
        $(divname).html('<img src="/images/default/index/miaosha.png" style="vertical-align: middle; margin-right: 10px;"><span style="vertical-align: middle">限时秒杀</span> <span style="vertical-align: middle"> <i class="time time-hour">'+hour+'</i>:<i class="time time-minute">'+minute+'</i>:<i class="time time-second">'+second+'</i> </span>');
    }

    if(type=="flashsale"){
    $(divname).html('距离本场结束: <span style="vertical-align: middle"> <i class="time time-hour">'+hour+'</i>:<i class="time time-minute">'+minute+'</i>:<i class="time time-second">'+second+'</i> </span>');
        return false;
    }
    
    if(type=="teamsale"){
    $(divname).html('剩余:'+hour+"小时"+minute+"分"+second+"秒");
      return false;
    }
}

function startShowCountDown(end_time_detail,divname,type){
    var timer=setInterval(function(){ShowCountDown(end_time_detail,divname,type);}, interval);
    return timer; 
    //window.clearTimeout(timer1);
}