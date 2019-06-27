<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="shortcut icon" href="" type="image/png">

    <title>403</title>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="{{ asset('css/default/403.css') }}" rel="stylesheet">

</head>


<body class="notfound" style="overflow: visible;">

<!-- Preloader -->
<!-- <div id="preloader" style="display: none;">
    <div id="status" style="display: none;"><i class="fa fa-spinner fa-spin"></i></div>
</div> -->

<section>

    <div class="lockedpanel">
        <div class="locked">
            <i class="fa fa-lock"></i>
        </div>
        <div class="logged">
            <h4>403</h4>
            <small class="text-muted">对不起，你没有权限操作这个页面</small>
        </div>
        <form method="post" action="#">
            <a href="javascript:history.back(-1);" class="btn btn-primary btn-block">点击返回</a>
        </form>
    </div><!-- lockedpanel -->

</section>


</body>
</html>