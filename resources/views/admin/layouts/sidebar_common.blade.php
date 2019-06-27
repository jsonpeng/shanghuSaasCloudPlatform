        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="http://7xkyc6.com1.z0.glb.clouddn.com/LOGO.gif" class="img-circle"
                     alt="User Image"/>
            </div>
            <div class="pull-left info">
                @if (Auth::guest())
                <p>{{ admin()->type }}后台 
                @if(admin()->type == '商户')  
                    @if(admin()->shop_type) @if(empty(now_shop_id())) {!! tag('[总部]') !!} @else  {!! tag('['.shop(now_shop_id())->name.']') !!}  @endif

                     <?php $admin_package = getAdminPackageStatus();?>
                     @if($admin_package['package']['canuse_shop_num'] > 1 && count($admin_package['shops']) > 1)
                     <span id="shop_change">{!! tag('切换','orange') !!}</span>
                     @endif

                     <ul id="shop_ul">
                        <?php $shops = now_shops(); ?>
                        @foreach ($shops as $item)
                        <li data-url="/zcjy/selectShopRedirect/{{ $item->id }}" class="shop_item @if(!empty(now_shop_id()) && $item->id == now_shop_id()) active @endif">{{ $item->name }}</li>
                        @endforeach
                    </ul>
                    
                    @else 
                    {!! tag('['.shop(now_shop_id())->name.'分店]') !!} 
                    @endif 
                @endif 
                </p>
                @else
                    <p>{{ admin()->nickname}}</p>
                @endif
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
            </div>
        </div>