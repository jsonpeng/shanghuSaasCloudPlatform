@if(funcOpen('FUNC_FOOTER'))
<div class="weui-planel ">
	<div class="weui-panel__hd store-info">
		<p><a href="/">店铺主页</a></p>
		<p>|</p>
		<p><a href="/usercenter">会员中心</a></p>
		<p>|</p>
		<p><a href="/page/weixin">关注我们</a></p>
		<p>|</p>
		<p><a href="/page/shopinfo">店铺信息</a></p>
	</div>
</div>
<div class="weui-planel store-text">
	<div class="weui-planel__hd">
		<p class="storeName">{{ getSettingValueByKeyCache('name') }}</p>
	</div>
	@if(funcOpen('FUNC_YUNLIKE'))
	<div class="weui-planel__bd">
		<a href="tel:13971217270">芸来软件技术支持 tel:13971217270</a>
	</div>
	@endif
</div>
@endif