<style>

.weui-dialog__btn_primary {color: {{ $theme_main_color }};}
.product-wrapper .price {color: #ff4e44;}
.product-wrapper .product-item2 .hot{background-color: {{$theme_main_color }};}
i.time {  background-color: {{ $theme_main_color}};}
.point-wrap .index-point-item .point-btn{  background-color:{{ $theme_main_color}};}
#coupon .swipe-item{  border: 1px dotted {{ $theme_main_color}};}
#coupon .weui-cell-fl{border: 1px dotted {{ $theme_main_color}};border-left: 0;}
#coupon .weui-cell-fr{  border: 1px dotted {{ $theme_main_color}};border-right: 0;}
#coupon .box .price-symbol{color: {{ $theme_main_color}};}
#coupon .box .price-num{  color: {{ $theme_main_color}};}
#coupon .box .price-info .price-btn{  background-color: {{ $theme_main_color}};}
.theme-item .title span{  color: {{ $theme_main_color}};}
.weui-icon-success{  color:{{ $theme_main_color}};}
.weui-tabbar .weui-bar__item_on .icon{  color: {{ $theme_main_color}};}
.cat-left .cat-row .active{  color: {{ $theme_main_color}};}
.cat-row.active{ color: {{ $theme_main_color}};}
.cat-selector li.active a{  color: {{ $theme_main_color}};}
#product_detail .product-price{  color:#ff4e44;}
.pin-team .qupin{  background-color: {{ $theme_main_color}};}

#product_price{  color: #ff4e44;}
.choicsel .choic-sel a.red{  background-color:{{ $theme_main_color}};}
.switcher .active{  color: {{ $theme_main_color}};}
.weui-cell.rollTip{  background-color: {{ $theme_main_color}};}
.zcjy-product-cart .price{  color: #ff4e44;}
.checkwrapper .right-botton01{  background-color: {{ $theme_main_color}};}
.zcjy-product-check .price span:nth-child(1){  color: #ff4e44;}
.zcjy-product-check .price .ft-l{  color: {{ $theme_main_color}};}
#check .price_final{  color: #ff4e44;}
#check .weui-panel__hd.tabList{  background-color: {{ $theme_main_color}};}
#check .weui-panel__hd.tabList .active{  color: {{ $theme_main_color}};}
.price_final{  color:#ff4e44;}
.promp-tips{  color: {{ $theme_main_color}};}
.user-address .select{  border: 1px solid {{ $theme_main_color}};  color: {{ $theme_main_color}};}
.weui-actionsheet__cell.coupon-cell .price{  color: {{ $theme_main_color}};}
.weui-actionsheet__cell.coupon-cell .usecoupon{  color: {{ $theme_main_color}};}
.order-item-title .status{  color: {{ $theme_main_color}};}
.order-item .userlist span{  color: {{ $theme_main_color}};}
.order-status{  background-color: {{ $theme_main_color}};}
.order-user-list .invite-button{  background-color: {{ $theme_main_color}};}
.app-wrapper .weui-media-box .weui-media-box__desc span{  color: {{ $theme_main_color}};}
.app-wrapper .contnet-wrapper .refund-types .refund-type.active{
    color: {{ $theme_main_color}};
    border: 1px solid {{ $theme_main_color}};
}
.app-wrapper .submit input {  background-color:{{ $theme_main_color}};}
.refundstatus{  color: {{ $theme_main_color}};}
.total span {  color: {{ $theme_main_color}};}
.weui-navbar__item.weui-bar__item_on{  color: {{ $theme_main_color}};}
.weui-grid.active-flashsale{  background-color: {{ $theme_main_color}};}
a.flash-sale-item .go{  background-color: {{ $theme_main_color}};}
.discount .weui-tab .weui-navbar .weui-bar__item_on{  color: {{ $theme_main_color}}; }
.discount .weui-tab .weui-navbar .weui-bar__item_on span{border-bottom: 1px solid {{ $theme_main_color}};}
.discount .weui-tab__panel .weui-media-box_hd .type{  color: {{ $theme_main_color}};  border: 1px solid {{ $theme_main_color}};}
.discount .weui-tab__panel .lose-effic .type{
    color: #d6d6d6;
    border-color:#d6d6d6;
}
.discount .weui-tab__panel .weui-media-box_hd .sum {  color: {{ $theme_main_color}};}
.bankcard .bc-1{  background: linear-gradient(30deg, {{ $theme_main_color}}, #ff9140);}
.bankcard .add-card a{  background-color: {{ $theme_main_color}};}
.credit .head{  background-color: {{ $theme_main_color}};}
.collect .order-item .weui-meida-box_bd .weui-media-box__desc .price{  color: {{ $theme_main_color}};}
.weui-cells.withdraw .withdraw-body .ft-l{  color: {{ $theme_main_color}};}
.withdraw-apply a{  background-color: {{ $theme_main_color}};}
.withdraw-sum .money-num{  color: {{ $theme_main_color}};}
.withdraw-sum .money-num input{  color: {{ $theme_main_color}};}
.withdraw-sum .withdraw-apply-info .weui-cell__bd{  color: {{ $theme_main_color}};}
.withdraw-sum .weui-btn{  background-color: {{ $theme_main_color}};}

.weui-icon-success-circle,.weui-icon-success-no-circle{  color: {{ $theme_main_color}};}
.order-user-list .img-circle{border: 2px solid {{ $theme_main_color}};}
.order-user-list .img-circle.pin:after{ background-color: {{ $theme_main_color}};}

/*商品购买按钮*/
.checkwrapper .right-botton02{background-color: {{ themeSecondColor() }};}

/*规格选择*/
.chooseDimension .Dimension-item.active{  background-color: {{ $theme_main_color}};}
.chooseDimension .buynow{  background-color: {{ $theme_main_color}};}

/*微信二维码分享页面*/
.shareCode{background-color:#fff;}
.shareCode .cut_line .weui-cell-fl{  background-color: {{ themeSecondColor() }};}
.shareCode .cut_line .weui-cell-fr{  background-color: {{ themeSecondColor() }};}

/*用户信息*/
.userInfo{background-color:{{ $theme_main_color}};}

/*LAYER UI样式修改*/
.layui-m-layer0 .layui-m-layerchild {
    width: 80%;
    max-width: 300px;
}
.layui-m-layercont{font-size: 15px;}
.layui-m-layerbtn span{font-size: 16px;}
.layui-m-layerbtn{display: flex; display: -webkit-flex;}
.layui-m-layerbtn span{
    -webkit-box-flex: 1;
    flex: 1;
}
.layui-m-layerbtn{background-color: #fff; border-top: 1px solid #D5D5D6;}
.layui-m-layerbtn span[no] {
    border-right: 1px solid #D5D5D6;
}
.layui-flow-more {margin: 0 auto;}

/*TABBAR 反转颜色*/
.weui-tabbar.reverse{background-color: {{ $theme_main_color }};}

/*主要按钮点击颜色*/
.weui-btn_primary:not(.weui-btn_disabled):active
{
    color: hsla(0,0%,100%,.6);
    background-color: {{ $theme_main_color }};
}
.weui-badge{  background-color:#ff4e44;}
.weui-tabbar__item.weui-bar__item_on .weui-tabbar__icon,
.weui-tabbar__item.weui-bar__item_on .weui-tabbar__icon > i,
.weui-tabbar__item.weui-bar__item_on .weui-tabbar__label{  color: {{ $theme_main_color}};}
.reverse .weui-tabbar__item.weui-bar__item_on .weui-tabbar__label{color:#fff;}
.weui-switch-cp__input:checked ~ .weui-switch-cp__box,
.weui-switch:checked {  border-color: {{ $theme_main_color}};background-color: {{ $theme_main_color}};}
.weui-btn_primary{  background-color: {{ $theme_main_color}};}
.weui-navbar__item.weui-bar__item_on span{  border-bottom: 1px solid {{ $theme_main_color}};}
</style>