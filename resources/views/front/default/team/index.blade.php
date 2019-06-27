@extends('front.default.layout.base')

@section('css')
    <style>
    </style>
@endsection

@section('content')
    <div class="nav_tip">
    <div class="img">
      <a href="/"><i class="icon ion-ios-arrow-left"></i></a></div>
        <p class="titile">拼团</p>
    </div>
    <div class="product-wrapper">

        @foreach ($teamSales as $teamSale)

            <a class="product-item2" href="/product/{{$teamSale->product->id}}">
                <div class="img">
                    <img src="{{$teamSale->product->image}}">
                </div>
                <div class="title">{{$teamSale->product_name}}</div>
                <div class="price">¥{{$teamSale->price}} <span style="float: right;">已拼{{$teamSale->sales_sum+$teamSale->sales_sum_base}}件</span></div>
            </a>
        @endforeach
    </div>



    @include(frontView('layout.nav'), ['tabIndex' => 2])
@endsection


@section('js')
    
@endsection
