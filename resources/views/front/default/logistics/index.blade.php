{{-- @extends('front.default.layout.base')

@section('css')

@endsection



<iframe id="frame" src="https://m.kuaidi100.com/index_all.html?type={{ $type }}&postid={{ $postid }}"></iframe>  




@section('js')
<script type="text/javascript">
    var height=$(window).height();
    var width=$(window).width();
    $('#frame').attr('style','height:'+height+'px;width:'+width+'px;');
</script>
@endsection --}}

{!! $html !!}