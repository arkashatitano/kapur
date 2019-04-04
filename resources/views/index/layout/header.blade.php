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
            <a href="/search" class="header__search">Поиск</a>
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
    <div class="main-menu__container">
        <div class="main-menu__row">

            @foreach($menu_list as $key => $item)

                <div class="main-menu__col">
                    <div class="main-menu__title">Об Ассоциации</div>

                    @if($item->child_count == 0)

                        <a href="@if($item->menu_redirect == '')/{{$item['menu_url_'.$lang]}}@else{{$item['menu_redirect']}}@endif" class="main-menu__title">{{$item['menu_name_'.$lang]}}</a>

                    @else

                        <div class="main-menu__title">{{$item['menu_name_'.$lang]}}</div>

                        <?php
                        $child_menu_list = \App\Models\Menu::where('is_show',1)
                                ->where('parent_id',$item->menu_id)
                                ->where('is_show_main',1)
                                ->where('is_show',1)
                                ->orderBy('sort_num','asc')
                                ->get();
                        ?>

                        <ul class="main-menu__list">

                            @foreach($child_menu_list as $key2 => $child_item)

                                <li class="main-menu__item">
                                    <a href="@if($child_item->menu_redirect == '')/{{$child_item['menu_url_'.$lang]}}@else{{$child_item['menu_redirect']}}@endif" class="main-menu__link">{{$child_item['menu_name_'.$lang]}}</a>
                                </li>

                            @endforeach

                        </ul>

                    @endif


                </div>

            @endforeach

        </div>
    </div>
</div>

