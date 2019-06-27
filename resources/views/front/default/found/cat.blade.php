@extends('front.social.layout.base')

@section('css')
    <style>
        .weui-grid{width: 25%;}
        .user-zone .weui-cell{border-bottom:1px solid #e0e0e0;}
    </style>
@endsection

@section('content')
    <div class="nav_tip">
      <div class="img">
        <a href="javascript:history.back(-1)">
            {{-- <img class="mail" id="mail" src="{{ asset('images/social/mail.png') }}"> --}}
            <i class="icon ion-ios-arrow-left"></i>
        </a></div>
      <p class="titile">{{ $cat->name }}</p>
    </div>

    
    @if ($newestPost->count() && $hot_cats->count())
        <!--  内容切换 -->
    <div class="weui-cell  tab-list">
        <div class="weui-cell__hd active"><span>最新</span></div>
        <div class="weui-cell__bd"><span>热门</span></div>
    </div>
    <div class="content-box">
        <!--最新的-->
        <div class="tab-item-1">
            <div class="tab-box-1">
                @foreach ($newestPost as $item)
                    <?php 
                        $images = $item['images'];
                        $user =! empty($item['admin']) ? $item['admin'] : $item['user'];
                        $products = $item['products'];
                    ?>
                    <div class="user-share-content scroll-item">
                        <div class="weui-cell">
                            <div class="weui-cell__hd user-img">
                                <img src="{!! $user['head_image'] !!}" onerror="javascript:this.src='{{ getSettingValueByKeyCache('logo') }}';" alt="">
                            </div>
                            <div class="weui-cell__bd">
                                <p class="share-name">{!! !empty($item['admin'])?$user->name:$user->nickname !!}</p>
                                <p class="date">{!! $item->humanTime !!}发布</p>
                            </div>
                        </div>
                  
                        <div class="weui-cell">
                            <div class="weui-cell__hd text">
                                {!! $item->content !!}
                            </div>
                        </div>

                        <div class="page__bd">
                                <div class="weui-gallery" id="gallery" >
                                        <img src="{{ asset('images/f2.jpg') }}"  class="weui-gallery__img" id="galleryImg" alt="">
                                    <div class="weui-gallery__opr">
                                        <a href="javascript:" class="weui-gallery__del">
                                            <i class="weui-icon-cancel"></i>
                                        </a>
                                    </div>
                                </div>
                        </div>

                        <div class="weui-cell">
                            <div class="pic-show-list">

                               @if(count($images))
                                    @foreach($images as $image)
                                    <div class="pic-show">
                                        <div class="img">
                                          <img src="{!! $image->url !!}" alt="">
                                        </div>
                                    </div>
                                    @endforeach
                              @endif

                            </div>
                        </div>

                        @if(count($products))
                            @foreach($products as $product)
                                <?php 
                                    $specs=$product['specs'];
                                ?>
                                @if(count($specs)>0)
                                    <!--有商品规格的商品-->
                                    <a class="weui-cell share-link" href="/product/{!! $product->id !!}" >
                                        <div class="weui-cell__hd">
                                           <img src="{{ $product->image }}" alt="">
                                        </div>
                                        <div class="weui-cell__bd">
                                             【@foreach ($specs as $spec_item)
                                                 @if($product['pivot']['spec_price_id']==$spec_item['id'])
                                                    {!! $spec_item->key_name !!}
                                                 @endif
                                                @endforeach】{!! $product->name !!}
                                        </div>
                                    </a>
                                @else
                                    <!--没有商品规格的商品-->
                                    <a class="weui-cell share-link" href="/product/{!! $product->id !!}">
                                        <div class="weui-cell__hd">
                                           <img src="{{ $product->image }}" alt="">
                                        </div>
                                        <div class="weui-cell__bd">
                                            {!! $product->name !!}
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        @endif

                    </div>
                @endforeach
            </div>
               <div style="display: none;text-align: center;padding-bottom: 50px;" id="postinfo">
                别扯了,没有更多了
                 </div>
        </div>

        <!--热门的-->
        <div class="tab-item-2">
            <div class="tab-box-2">
                @foreach ($hotPost as $item)
                    <?php 
                        $images = $item['images'];
                        $user =! empty($item['admin']) ? $item['admin'] : $item['user'];
                        $products = $item['products'];
                    ?>
                    <div class="user-share-content scroll-item">
                        <div class="weui-cell">
                            <div class="weui-cell__hd user-img">
                                <img src="{!! $user['head_image'] !!}" onerror="javascript:this.src='{{ getSettingValueByKeyCache('logo') }}';" alt="">
                            </div>
                            <div class="weui-cell__bd">
                                <p class="share-name">{!! !empty($item['admin']) ? $user->name : $user->nickname !!}</p>
                                <p class="date">{!! $item->created_at->diffForHumans() !!}发布</p>
                            </div>
                        </div>
                 
                        <div class="weui-cell">
                            <div class="weui-cell__hd text">
                                {!! $item->content !!}
                            </div>
                        </div>
                        <div class="weui-cell">
                            <div class="pic-show-list">

                               @if(count($images))
                                    @foreach($images as $image)
                                    <div class="pic-show">
                                        <div class="img">
                                          <img src="{!! $image->url !!}" alt="">
                                        </div>
                                    </div>
                                    @endforeach
                              @endif

                            </div>
                        </div>

                        @if(count($products))

                            @foreach($products as $product)
                            <?php $specs=$product['specs'];?>

                                @if(count($specs)>0)
                                    <!--有商品规格的商品-->
                                    <a class="weui-cell share-link" href="/product/{!! $product->id !!}" >
                                        <div class="weui-cell__hd">
                                           <img src="{{ $product->image }}" alt="">
                                        </div>
                                        <div class="weui-cell__bd">
                                             【@foreach ($specs as $spec_item)
                                                 @if($product['pivot']['spec_price_id']==$spec_item['id'])
                                                    {!! $spec_item->key_name !!}
                                                 @endif
                                                @endforeach】{!! $product->name !!}
                                        </div>
                                    </a>
                                @else
                                    <!--没有商品规格的商品-->
                                    <a class="weui-cell share-link" href="/product/{!! $product->id !!}">
                                        <div class="weui-cell__hd">
                                           <img src="{{ $product->image }}" alt="">
                                        </div>
                                        <div class="weui-cell__bd">
                                            {!! $product->name !!}
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        @endif

{{--                         <div class="share-ways">
                            <div class="like"><!-- <i class="icon ion-thumbsup"></i><span>43</span> -->
                                <div class="praise">
                                    <span id="praise"><i class="icon ion-thumbsup"></i></span>
                                    <span id="praise-txt">43</span>
                                    <span id="add-num"><em>+1</em></span>
                                </div>
                            </div>
                            <div class="share-counts"><i class="icon ion-ios-upload-outline"></i><span>99</span></div>
                        </div> --}}

                    </div>
                @endforeach
            </div>
            <div style="display: none;text-align: center;padding-bottom: 50px;" id="postinfo">
            别扯了,没有更多了
            </div>
        </div>
    </div>
    @else
        <div class="no-content">
            <img src="{{ asset('images/notopic.png') }}">
            <div>暂无发现任何内容~</div>
        </div>
    @endif
    
    @include(frontView('layout.nav'), ['tabIndex' => 5])
@endsection


@section('js')
    <script type="text/javascript" class="uploader js_show">
        $(function(){
            var $gallery = $("#gallery"), $galleryImg = $("#galleryImg"),
                $uploaderFiles = $(".pic-show-list");

            $uploaderFiles.on("click", " .pic-show .img img", function(){
                $galleryImg.attr("src", this.getAttribute("src"));
                console.log($galleryImg);
                // console.log($galleryImg.attr("src"));
                // console.log(this.getAttribute("src"));
                $gallery.fadeIn(100);
            });
            $gallery.on("click", function(){
                $gallery.fadeOut(100);
            });
        });</script>
    <script type="text/template" id="template">
        @{{~it:value:index}}
           <div class="user-share-content scroll-item">
                <div class="weui-cell">
                    <div class="weui-cell__hd user-img">
                        @{{? value.admin != null || value.user.head_image == null }}
                            <img src="/images/social/brand.jpg" alt="">
                        @{{??}}
                            <img src="@{{=value.user.head_image}}" alt="">
                        @{{?}}
                    </div>
                    <div class="weui-cell__bd">
                        @{{? value.admin != null }}
                             <p class="share-name">@{{=value.admin.name}}</p>
                        @{{??}}
                             <p class="share-name">@{{=value.user.nickname}}</p>
                        @{{?}}
                        <p class="date">@{{=value.humanTime}}</p>
                    </div>
                </div>

                <div class="weui-cell">
                    <div class="weui-cell__hd text">
                        @{{=value.content}}
                    </div>
                </div>

                <div class="weui-cell">
                    <div class="pic-show-list">
                            @{{~value.images:value2:index2}}
                                <div class="pic-show">
                                    <div class="img">
                                      <img src="@{{=value2.url}}" alt="">
                                    </div>
                                </div>
                            @{{~}}
                    </div>
                </div>

                    @{{~value.products:value3:index3}}
                           @{{? value3.specs != null }}
                            <!--有商品规格的商品-->
                                <a class="weui-cell share-link" href="/product/@{{=value3.id}}" >
                                    <div class="weui-cell__hd">
                                        @{{? value3['image'] != null }}
                                            <img src="@{{=value3.image}}" alt="">
                                        @{{?}}
                                    </div>
                                    <div class="weui-cell__bd">
                                         @{{~value3.specs:value4:index4}}
                                                @{{? value3['pivot']['spec_price_id'] == value4['id'] }}
                                                   【 @{{=value4.key_name}}】
                                                @{{?}}
                                          @{{~}}@{{=value3.name}}
                                    </div>
                                </a>
                            @{{??}}
                            <!--没有商品规格的商品-->
                                <a class="weui-cell share-link" href="/product/@{{=value3.id}}">
                                    <div class="weui-cell__hd">
                                        @{{? value3['image'] != null }}
                                            <img src="@{{=value3.image}}" alt="">
                                        @{{?}}
                                    </div>
                                    <div class="weui-cell__bd">
                                        @{{=value3.name}}
                                    </div>
                                </a>
                            @{{?}}
                    @{{~}}

                <div class="share-ways">
                    <div class="like">
                        <div class="praise">
                            <span id="praise"><i class="icon ion-thumbsup"></i></span>
                            <span id="praise-txt">43</span>
                            <span id="add-num"><em>+1</em></span>
                        </div>
                    </div>
                    <div class="share-counts"><i class="icon ion-ios-upload-outline"></i><span>99</span></div>
                </div>
            </div>
        @{{~}}
    </script>
<!-- 无限加载 -->
<script src="{{ asset('vendor/jquery.endless-scroll-1.3.js') }}"></script>
<script type="text/javascript">
        var fireEvent = true;
        var working = false;
        var type=0;
        var parent_box=$('.tab-item-'+(parseInt(type)+1));
        var scroll_box=$('.tab-box-'+(parseInt(type)+1));
        var is_hot=0;
        $('.tab-list>div').on('click', function(event) {
            event.preventDefault();
            $(this).addClass('active').siblings().removeClass('active');
            var index=$(this).index();
            //是否请求热门的
            type=index;
            fireEvent=true;
            parent_box=$('.tab-item-'+(parseInt(type)+1));
            scroll_box=$('.tab-box-'+(parseInt(type)+1));
            $('.content-box>div').hide().eq(index).show();
        });

        //分类id
        var cat_id='{!! $cat->id !!}';
        //ajax请求地址
        var request_url = '/api/post_found/'+cat_id;
        //父节点容器
        console.log(parent_box);

         $(document).endlessScroll({
            bottomPixels: 250,
            fireDelay: 10,
            ceaseFire: function(){
              if (!fireEvent) {
                return true;
              }
            },
            callback: function(p){
              if(!fireEvent || working){return;}
              working = true;
              //加载函数
              $.ajaxSetup({ 
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });
              $.ajax({
                url:request_url,
                data:{
                    skip:parent_box.find('.scroll-item').length,
                    take:8,
                    is_hot:type
                },
                type:"GET",
                success:function(data){
                    if(data.status_code==0){
                      working = false;
                      var all_posts=data.data;
                      console.log(all_posts.length);
                      if (all_posts.length == 0) {
                        fireEvent = false;
                        console.log('没有更多了');
                        parent_box.find('#postinfo').show();
                        return;
                      }
                      var tempFn = doT.template($('#template').html());
                      var resultHTML = tempFn(all_posts);
                      console.log(resultHTML);
                      scroll_box.append(resultHTML);
                    }
                  }
              });
            }
        });
</script>
@endsection