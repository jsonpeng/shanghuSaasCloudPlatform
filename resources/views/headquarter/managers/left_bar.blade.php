        <div class="col-sm-3 col-lg-2">
            <ul class="nav nav-pills nav-stacked nav-email">
                <li class="{{ $input['type'] == '代理商' || Request::is('zcjy/managers') && $input['type'] != '管理员'  ? 'active' : '' }}">
                    <a href="{!! route('managers.index').'?type=代理商' !!}">
                        <span class="badge pull-right"></span>
                        <i class="fa fa-user"></i> 代理商设置
                    </a>
                </li>

                <li class="{{ $input['type'] == '管理员' ? 'active' : '' }}">
                    <a href="{!! route('managers.index').'?type=管理员' !!}">
                        <span class="badge pull-right"></span>
                        <i class="fa fa-users"></i>管理员设置
                    </a>
                </li>
            </ul>
        </div>