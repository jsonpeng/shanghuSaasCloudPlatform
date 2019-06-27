@extends('admin.layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/colorpicker/css/colorpicker.css') }}">
    <style type="text/css">
        .theme-browser .theme {
            cursor: pointer;
            float: left;
            margin: 0 4% 4% 0;
            position: relative;
            width: 28%;
            border: 1px solid #ddd;
            -webkit-box-shadow: 0 1px 1px -1px rgba(0,0,0,.1);
            box-shadow: 0 1px 1px -1px rgba(0,0,0,.1);
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        .theme-browser .theme .theme-screenshot {
            display: block;
            overflow: hidden;
            position: relative;
            -webkit-backface-visibility: hidden;
            -webkit-transition: opacity .2s ease-in-out;
            transition: opacity .2s ease-in-out;
        }
        .theme-browser .theme .theme-screenshot img {
            height: auto;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            -webkit-transition: opacity .2s ease-in-out;
            transition: opacity .2s ease-in-out;
        }
        .theme-browser .theme .theme-screenshot:after {
            content: "";
            display: block;
            padding-top: 66.66666%;
        }
        .theme-browser .theme .theme-name {
            font-size: 15px;
            font-weight: 600;
            margin: 0;
            padding: 15px;
            -webkit-box-shadow: inset 0 1px 0 rgba(0,0,0,.1);
            box-shadow: inset 0 1px 0 rgba(0,0,0,.1);
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            background: #fff;
            background: rgba(255,255,255,.65);
        }
        .theme-browser .theme.active .theme-name {
            background: #23282d;
            color: #fff;
            padding-right: 110px;
            font-weight: 300;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.5);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.5);
        }
        .theme-browser .theme .theme-actions {
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=1)";
            opacity: 1;
            -webkit-transition: opacity .1s ease-in-out;
            transition: opacity .1s ease-in-out;
            position: absolute;
            bottom: 0;
            right: 0;
            height: 38px;
            padding: 9px 10px 0;
            background: rgba(244,244,244,.7);
            border-left: 1px solid rgba(0,0,0,.05);
        }
        .theme-browser .theme.active .theme-actions {
            background: rgba(49,49,49,.7);
            border-left: none;
            opacity: 1;
        }
        .wp-core-ui .button, .wp-core-ui .button-primary, .wp-core-ui .button-secondary {
            display: inline-block;
            text-decoration: none;
            font-size: 13px;
            line-height: 26px;
            height: 28px;
            margin: 0;
            padding: 0 10px 1px;
            cursor: pointer;
            border-width: 1px;
            border-style: solid;
            -webkit-appearance: none;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            white-space: nowrap;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        .wp-core-ui .button, .wp-core-ui .button-secondary {
            color: #fff;
            border-color: #ccc;
            background: #23282d;
            -webkit-box-shadow: 0 1px 0 #ccc;
            box-shadow: 0 1px 0 #ccc;
            vertical-align: top;
        }
        a.
        .theme-browser .theme .theme-actions .button {
            float: none;
            margin-left: 3px;
        }
        .theme-browser .theme.focus .theme-actions,
        .theme-browser .theme:focus .theme-actions,
        .theme-browser .theme:hover .theme-actions
        {
            opacity: 1;;

            -ms-filter: 'progid:DXImageTransform.Microsoft.Alpha(Opacity=100)';
        }

        .color-palette-box h4 {
    position: absolute;
    top: 100%;
    left: 25px;
    margin-top: -40px;
    color: rgba(255, 255, 255, 0.8);
    font-size: 12px;
    display: block;
    z-index: 7;
}
.color-palette-set {
    margin-bottom: 15px;
}
.color-palette {
    height: 35px;
    line-height: 35px;
    text-align: center;
}

        #colorSelector, #colorSelector2 {
            position: relative;
            width: 36px;
            height: 36px;
        }
        #colorSelector div, #colorSelector2 div {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 30px;
            height: 30px;
            background: url({{ asset('vendor/colorpicker/images/select.png') }}) center center;
        }
        th{
            width: 150px;
        }
        tr{
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
    </style>
    
@endsection

@section('content')
<section class="content theme-browser" style="overflow: hidden;">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li>
                <a href="javascript:;">
                    <span style="font-weight: bold;">商城设置</span>
                </a>
            </li>

            @if (Config::get('web.FUNC_THEME'))
                <li class="active">
                    <a href="#tab_1" data-toggle="tab">主题布局</a>
                </li>
            @endif

            @if (Config::get('web.FUNC_COLOR'))
                <li class="@if (!Config::get('web.FUNC_THEME')) active @endif">
                    <a href="#tab_2" data-toggle="tab">颜色设置</a>
                </li>
            @endif
            

        </ul>
        <div class="tab-content">
            @if (Config::get('web.FUNC_THEME'))
            <div class="tab-pane active" id="tab_1">
                @foreach ($themes as $theme)
                    @if ($curTheme['name'] == $theme['name'])
                        <div class="theme active" tabindex="0" aria-describedby="twentyseventeen-action twentyseventeen-name" data-slug="twentyseventeen">
                            <div class="theme-screenshot">
                                <img src="{{ asset($theme['image']) }}" alt="">
                            </div>
                            <div class="update-message notice inline notice-warning notice-alt"></div>
                            <h2 class="theme-name" id="twentyseventeen-name">
                                <span>活跃：</span>{{ $theme['display_name'] }}</h2>
                            <div class="theme-actions"></div>
                        </div>
                    @else
                        <div class="theme" tabindex="0" aria-describedby="twentyfifteen-action twentyfifteen-name" data-slug="twentyfifteen">
                            <div class="theme-screenshot">
                                <img src="{{ asset($theme['image']) }}" alt="">
                            </div>
                            <div class="update-message notice inline notice-warning notice-alt"></div>
                            <h2 class="theme-name" id="twentyfifteen-name">{{ $theme['display_name'] }}</h2>
                    
                            <div class="theme-actions">
                                <a class="button activate" href="/zcjy/settings/themeSetting/{{ $theme['name'] }}" aria-label="激活{{ $theme['display_name'] }}">启用</a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            @endif

            @if (Config::get('web.FUNC_COLOR'))
            <div class="tab-pane @if (!Config::get('web.FUNC_THEME')) active @endif" id="tab_2">
                <table>
                    <thead>
                        <tr>
                            <th>类型</th>
                            <th>颜色设置</th>
                            <th>色值</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>主色调</td>
                            <td><div id="colorSelector"><div style="background-color: {{ themeMainColor() }}"></div></div></td>
                            <td><input type="text" name="maincolor" value="{{ themeMainColor() }}"></td>
                        </tr>
                        <tr>
                            <td>次色调</td>
                            <td><div id="colorSelector2"><div style="background-color: {{ themeSecondColor() }}"></div></div></td>
                            <td><input type="text" name="secondcolor" value="{{ themeSecondColor() }}"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><button type="submit" class="btn btn-primary pull-right" onclick="saveColor()">保存</button></td>
                        </tr>
                    </tbody>
                </table>

                <div class="row " style="margin-bottom: 30px; margin-top: 15px;">
                    <div>不知道设什么颜色好看？ 试试我们为您推荐的颜色配置吧</div>
                    @foreach ($theme_colors as $theme_color)
                        <div class="col-sm-3 col-md-2" style="margin-bottom: 15px; cursor: pointer;" onclick="changeColor('{{ $theme_color['maincolor'] }}', '{{ $theme_color['secondcolor'] }}')">
                            <div class="color-palette-set">
                                <div class="color-palette" style="background-color: {{ $theme_color['secondcolor'] }}"><span>次色调 {{ $theme_color['secondcolor'] }}</span></div>
                                <div class="color-palette" style="background-color: {{ $theme_color['maincolor'] }}"><span>主色调 {{ $theme_color['maincolor'] }}</span></div>
                            </div>
                          <h4 class="text-center" style="font-size: 12px;">{{ $theme_color['name'] }}</h4>
                        </div><!-- /.col -->
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection


@section('scripts')
    <script type="text/javascript" src="{{ asset('vendor/colorpicker/js/colorpicker.js') }}"></script>
    
    <script>
        $('#colorSelector').ColorPicker({
            color: '{{ themeMainColor() }}',
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                $('#colorSelector div').css('backgroundColor', '#' + hex);
                $('input[name=maincolor]').val('#' + hex);
            }
        });

        $('#colorSelector2').ColorPicker({
            color: '{{ themeSecondColor() }}',
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                $('#colorSelector2 div').css('backgroundColor', '#' + hex);
                $('input[name=secondcolor]').val('#' + hex);
            }
        });

        function changeColor(maincolor, secondcolor) {
            $('input[name=maincolor]').val(maincolor);
            $('input[name=secondcolor]').val(secondcolor);
            $('#colorSelector div').css('backgroundColor', maincolor);
            $('#colorSelector2 div').css('backgroundColor', secondcolor);
        }

        function saveColor() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'/zcjy/ajax/set_theme_color',
                type:'post',
                data:{
                    maincolor: $('input[name=maincolor]').val(),
                    secondcolor: $('input[name=secondcolor]').val()
                },
                success:function(data){
                    if (data.code == 0) {
                        layer.msg(data.message, {icon: 1});
                      }else{
                        layer.msg(data.message, {icon: 5});
                      }
                }
            });
        }
    </script>
@endsection