@extends('front.default.layout.base')

@section('css')
    <style>

    </style>
@endsection

@section('content')
    <div class="cat-left">
      @foreach($categories as $category)
        <a class="cat-row @if($category->id == $cat_id) active @endif" href="/category/{{ $category->id}}" >{{ $category->name}}</a>
      @endforeach
    </div>
    <div class="cat-right" id="scroll02">
      <div class="weui-grids">
      @foreach($childrenCats as $cat)
        
        <a href="/category/{{ $cat->id }}" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="http://temp.im/72x72/333/EEE" alt="">
            </div>
            <p class="weui-grid__label">{{ $cat->name }}</p>
        </a>
      
      @endforeach
      </div>
    </div>
    
    @include('front.default.layout.nav')
@endsection
