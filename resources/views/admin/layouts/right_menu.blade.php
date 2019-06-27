  <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="http://7xkyc6.com1.z0.glb.clouddn.com/LOGO.gif"
                                     class="user-image" alt="User Image"/>
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{!! auth('admin')->user()->nickname !!}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="http://7xkyc6.com1.z0.glb.clouddn.com/LOGO.gif"
                                         class="img-circle" alt="User Image"/>
                                
                                        <p>
                                            {!! admin()->nickname !!}
                                              @if(admin()->type != '管理员')
                                                <small>账户余额:{!! admin()->use_money !!}</small>
                                              @endif
                                        </p>
                                
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a target="_blank" href="/zcjy/password/reset" class="btn btn-default btn-flat">重置密码</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{!! url('/zcjy/logout') !!}" class="btn btn-default btn-flat">退出</a>
                                    </div>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:;" id="notice_sidebar"><i class="fa fa-envelope-o"></i>@if(count($adminUnreadNotices)) <span class="label label-danger">{{ count($adminUnreadNotices) }}</span> @endif</a>
                        </li>
                    </ul>
</div>