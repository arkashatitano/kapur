<!doctype html>
<html class="no-js" lang="ru">

@include('index.layout.app')

<body>

<div class="layout">
    <div class="layout__wrapper">
    
    @include('index.layout.header')
    
    @yield('content')
    
    @include('index.layout.footer')

    </div>
</div>

<noindex>

    <!-- Modal Cta Begin -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-subs">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">{{Lang::get('app.subscribe_label')}}</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&#10005;</span>
                    </button>
                </div>
                <form class="modal__form">
                    <div class="form-group">
                        <input type="text" id="name_subscribe" name="name" class="form-control" placeholder="{{Lang::get('app.user_name')}}">
                    </div>
                    <div class="form-group">
                        <input type="email" id="email_subscribe" name="email" required class="form-control" placeholder="Email">
                    </div>
                    <button type="button" onclick="addSubscription()" class="button -default modal__button">{{Lang::get('app.send')}}</button>
                </form>
            </div>
        </div>
    </div>
    <!--/. Modal Cta End -->

    <!-- Modal Success Begin -->
    <div class="modal fade" id="modal-success" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">{{Lang::get('app.thanks')}}</h2>
                    <div class="modal-subtitle">{{Lang::get('app.manager_call')}}</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&#10005;</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--/. Modal Success End -->

</noindex>

<noindex>

    <!-- Modal Cta Begin -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-cta">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&#10005;</span>
                </button>
                <div class="modal-header">
                    <div class="modal__title">Оставьте заявку</div>
                    <div class="modal__subtitle">и наш менеджер перезвонит Вам в течении 15 минут</div>
                </div>
                <div class="modal__body">
                    <form>
                        <div class="form-group">
                            <input type="text" name="name" class="form-control js-name is-required" placeholder="Имя">
                        </div>
                        <div class="form-group">
                            <input type="text" name="phone" class="form-control js-phone is-required" placeholder="Телефон">
                        </div>
                        <div class="form-group">
                            <input type="text" name="email" class="form-control js-email is-required" placeholder="Email">
                        </div>
                        <button type="submit" class="button -default">Отправить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/. Modal Cta End -->

    <!-- Modal Success Begin -->
    <div class="modal fade" id="modal-success" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Спасибо!</h2>
                    <div class="modal-subtitle">Наш менеджер перезвонит Вам!</div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&#10005;</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--/. Modal Success End -->

    <!-- Modal Iframe Begin -->
    <div class="modal bm-modal fade" id="iframe-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <div class="bm-modal__embed">
                        <iframe class="bm-modal__embed-item jsBmEmbedItem" frameborder="0" src=""></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/. Modal Iframe End -->

    <!-- Modal Search Begin -->
    <div class="modal modal-search fade" id="modal-search" tabindex="-1" role="dialog" aria-labelledby="Search">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&#10005;</span>
        </button>
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="modal-search__form">
                    <button type="submit" class="button modal-search__button">
                        <svg width="24" height="24" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.625 10.5H11.0325L10.8225 10.2975C11.5575 9.4425 12 8.3325 12 7.125C12 4.4325 9.8175 2.25 7.125 2.25C4.4325 2.25 2.25 4.4325 2.25 7.125C2.25 9.8175 4.4325 12 7.125 12C8.3325 12 9.4425 11.5575 10.2975 10.8225L10.5 11.0325V11.625L14.25 15.3675L15.3675 14.25L11.625 10.5ZM7.125 10.5C5.2575 10.5 3.75 8.9925 3.75 7.125C3.75 5.2575 5.2575 3.75 7.125 3.75C8.9925 3.75 10.5 5.2575 10.5 7.125C10.5 8.9925 8.9925 10.5 7.125 10.5Z"
                                  fill="#2D2E35" />
                        </svg>
                    </button>
                    <input type="search" class="form-control modal-search__input" placeholder="Поиск">
                </form>
            </div>
        </div>
    </div>
    <!--/. Modal Search End -->

</noindex>

<script src="/custom/js/jquery.js"></script>
<script src="/static/js/main.min.js"></script>
<script src="/static/js/separate-js/scripts.js"></script>
<script src="/custom/js/custom.js?v=17"></script>


<script>
    @if(isset($error))
        showError('{{$error}}');
    @endif
</script>

@yield('js')

</body>
</html>