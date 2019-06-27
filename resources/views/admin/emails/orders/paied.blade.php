@component('mail::message')
# 订单通知

您有新的订单</br>
订单编号：{{ $order->snumber }}</br>
订单金额：{{ $order->price }}</br>


@component('mail::table')

 <?php
 	$items = $order->items;
 ?>
| 商品       | 价格         | 数量  |
| ------------- |:-------------:| --------:|
@foreach($items as $element)
	| {{ $element->name }} {{ $element->spec_keyname }} | {{ $element->price }} | {{ $element->count }} |
@endforeach

@endcomponent

@endcomponent
