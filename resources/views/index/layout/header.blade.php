<header class="header">
    <div class="container header__container">
        <button type="button" class="burger"></button>
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