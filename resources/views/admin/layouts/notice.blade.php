<aside class="control-sidebar control-sidebar-dark" id="notice_sidebar_show">
            <!-- Create the tabs -->
            <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">

                   <div id="control-sidebar-theme-demo-options-tab" class="tab-pane active">
                        <div>

                            <h4 class="control-sidebar-heading">消息中心</h4> 

                            @if(count($adminUnreadNotices))
                            <?php $i=0;?>
                                @foreach ($adminUnreadNotices as $notice)
                                    <?php $i++;?>
                                    @if($i<11)
                                    <div class="form-group"><p><small><i class="fa fa-clock-o"></i>{{ $notice->currentTime }}</small>&nbsp;&nbsp;&nbsp;&nbsp;<strong style="color: red">[{{ $notice->data['type'] }}]</strong>&nbsp;&nbsp;&nbsp;&nbsp;{!! $notice->data['content'] !!}</p></div>
                                    @endif
                                @endforeach
                            @else 
                                <div class="form-group"><p style="text-align: center;">暂无未读消息</p></div>
                            @endif

                        </div>
                   </div>

            </div>
            <div style="border-top: 1px solid #ddd;text-align: center;font-size: 14px;color: white;padding-top: 12px;padding-bottom: 12px;"><a href="{{  route('message.index') }}">进入消息中心</a></div>
</aside>