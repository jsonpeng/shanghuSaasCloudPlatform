<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>{!! $title !!}</title>
         <link rel="stylesheet" href="{{ asset('css/mail.css') }}">
    </head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                <tr>
                    <td align="center" valign="top" id="bodyCell">
                        <!-- BEGIN TEMPLATE // -->
                        <table border="0" cellpadding="0" cellspacing="0" id="templateContainer">
                        
                            <tr>
                                <td align="center" valign="top">
                                    <!-- BEGIN HEADER // -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateHeader">
                                        <tr>
                                            <td valign="top" class="headerContent">
                                                <img src="http://www.yunlike.cn/img/logo.png" style="max-width:600px;" id="headerImage" mc:label="header_image" mc:edit="header_image" mc:allowdesigner mc:allowtext />
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // END HEADER -->
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <!-- BEGIN BODY // -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateBody">
                                        <tr>
                                            <td valign="top" class="bodyContent" mc:edit="body_content">
                                                <h1>芸来软件提醒您，有新的客户下单</h1>
                                                <div>客户姓名：@if($user){{$user->name}}@endif</div>
                                                <div>电话：@if($user)<a href="tel:{{$user->mobile}}">{{$user->mobile}}</a>@endif</div>
                                                  @foreach($items as $item)
                                                <div style="background-color: #edfbf8;">
                                                        <div >编号{{ $item->id }}</div>
                                                        <div >商品   <img src="{{ $item->pic }}" alt="" style="height: 25px;">{{ $item->name }}</div>
                                                        <div >规格{{ $item->unit }}</div>
                                                        <div >数量{{ $item->count }}</div>
                                                        <div >单价{{ $item->price }}</div>
                                                        <div>总价{{ round($item->count * $item->price) }}</div>
                                                    </div>
                                                    @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // END BODY -->
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top">
                                    <!-- BEGIN FOOTER // -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateFooter">
                                        <tr>
                                            <td valign="top" class="footerContent" style="padding-top:0; padding-bottom:15px;" mc:edit="footer_content02">
                                             <a  href="{!! route('orders.show',$order_id)!!}" >更多订单详情</a>
                                            <a style="margin-top: 15px; display: block;" href="http://www.yunlike.cn" >芸来软件 www.yunlike.cn</a>
                                             <a  ><?php echo date('y-m-d h:i',time());?></a>
                                            </td>
                                       
                                        </tr>
                                    </table>
                                    <!-- // END FOOTER -->
                                </td>
                            </tr>
                        </table>
                        <!-- // END TEMPLATE -->
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>