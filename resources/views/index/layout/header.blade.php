<header class="header">
    <div class="container header__container">
        <button type="button" id="collapse-menu" class="burger"></button>
        <div class="logo">
            <a href="/">
                <div class="logo__img"></div>
            </a>
            <div class="logo__slogan">
                {!! \App\Http\Helpers::getInfoText(20) !!}
            </div>
        </div>
        <div class="header__right">
            <ul class="lang header__lang">
                <li class="lang__item">
                    <a href="{{\App\Http\Helpers::setSessionLang('kz',$request)}}" class="lang__link @if($lang == 'kz') -active @endif">QAZ</a>
                </li>
                <li class="lang__item">
                    <a href="{{\App\Http\Helpers::setSessionLang('ru',$request)}}" class="lang__link @if($lang == 'ru') -active @endif">РУС</a>
                </li>
                <li class="lang__item">
                    <a href="{{\App\Http\Helpers::setSessionLang('en',$request)}}" class="lang__link @if($lang == 'en') -active @endif">eng</a>
                </li>
            </ul>
            <a href="#" class="header__search" data-toggle="modal" data-target="#modal-search">Поиск</a>
        </div>
    </div>
</header>


<?php

$menu_list = \App\Models\Menu::where('is_show',1)
        ->where('parent_id',null)
        ->where('is_show_main',1)
        ->orderBy('sort_num','asc')
        ->select('*',
                DB::raw('(SELECT count(*) FROM menu as child
                          WHERE child.is_show_main = 1
                          and child.parent_id = menu.menu_id
                          and child.is_show = 1
                          and child.deleted_at is null) as child_count')
        )
        ->get();
?>

<div class="main-menu">
    <div class="container main-menu__container">
        <ul class="nav-menu" id="accordion">

            @foreach($menu_list as $key => $item)

                <li class="menu-item @if($key == 0) active @endif">

                    @if($item->child_count == 0)

                        <a href="@if($item->menu_redirect == '')/{{$item['menu_url_'.$lang]}}@else{{$item['menu_redirect']}}@endif" class="menu-link"  aria-expanded="true" aria-controls="menu{{$item['menu_id']}}">{{$item['menu_name_'.$lang]}}</a>

                    @else

                        <a href="#" class="menu-link" data-toggle="collapse" data-target="#menu{{$item['menu_id']}}" aria-expanded="true" aria-controls="menu{{$item['menu_id']}}">{{$item['menu_name_'.$lang]}}</a>

                    @endif

                    <div class="sub_menu container collapse @if($key == 0) show @endif" id="menu{{$item['menu_id']}}" data-parent="#accordion">
                            <div class="row no-gutters">

                                <?php
                                $child_menu_list = \App\Models\Menu::where('is_show',1)
                                        ->where('parent_id',$item->menu_id)
                                        ->where('is_show_main',1)
                                        ->where('is_show',1)
                                        ->orderBy('sort_num','asc')
                                        ->get();
                                ?>

                                <div class="col-lg-6">
                                    <div class="left-menu">

                                        @foreach($child_menu_list as $key2 => $child_item)

                                            @if($key2 < 8)

                                                <a href="@if($child_item->menu_redirect == '')/{{$child_item['menu_url_'.$lang]}}@else{{$child_item['menu_redirect']}}@endif" class="sub-link">{{$child_item['menu_name_'.$lang]}}</a>

                                            @endif

                                        @endforeach

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="right-menu">

                                        @foreach($child_menu_list as $key2 => $child_item)

                                            @if($key2 > 7)

                                                <a href="@if($child_item->menu_redirect == '')/{{$child_item['menu_url_'.$lang]}}@else{{$child_item['menu_redirect']}}@endif" class="sub-link">{{$child_item['menu_name_'.$lang]}}</a>

                                            @endif

                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>



                </li>

            @endforeach

        </ul>
    </div>
</div>