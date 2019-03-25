<div class="modal -wide" tabindex="-1" role="dialog" id="modal-pay">
    <div class="modal-dialog" role="document">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&#10005;</span>
        </button>
        <div class="modal__inner">
            <form class="register">
                <div class="h1 mb-4 mb-md-5">Купить журнал</div>
                <div class="control">
                    <div class="control__group">
                        <input class="with-gap pay_type" checked name="pay_type" value="online" type="radio" id="test3" />
                        <label for="test3">Купить онлайн, электронная версия журнала {{$magazine->magazine_price}}тг</label>
                    </div>
                </div>
                <div class="control">
                    <div class="control__group">
                        <input class="with-gap pay_type" name="pay_type" value="online_delivery" type="radio" id="test4" />
                        <label for="test4">Купить онлайн, журнал с доставкой {{$magazine->magazine_price_delivery}}тг</label>
                    </div>
                </div>
                <div class="control">
                    <div class="control__group">
                        <input class="with-gap pay_type" name="pay_type" value="cash" type="radio" id="test5" />
                        <label for="test5">Купить по наличному/безналичному платежу для юридических лиц</label>
                    </div>
                </div>
                <div class="text-left">
                    <button type="button" onclick="payMagazine()" class="button -default register__button">Купить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-success" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Спасибо!</h2>
                <div class="modal-subtitle">Наш менеджер свяжется с Вами!</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&#10005;</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal -wide" tabindex="-1" role="dialog" id="pay-information">
    <div class="modal-dialog" role="document">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&#10005;</span>
        </button>
        <div class="modal__inner">
            <form class="register">
                <div class="h1 mb-4 mb-md-5">Купить журнал</div>
                <div class="control">
                    <div class="control__group">
                        <input type="hidden" id="magazine_id" value="{{$magazine['magazine_id']}}"/>
                        <input type="text" id="user_name" class="control__input" required />
                        <label class="control__label">ФИО</label>
                        <span class="control__required">*</span>
                    </div>
                    <span class="control__help">Это поле нужно заполнить</span>
                </div>
                <div class="control">
                    <div class="control__group">
                        <input type="text" id="organization_name" class="control__input" required />
                        <label class="control__label">Организация</label>
                        <span class="control__required">*</span>
                    </div>
                    <span class="control__help">Это поле нужно заполнить</span>
                </div>
                <div class="control">
                    <div class="control__group">
                        <input type="text" id="position" class="control__input" required />
                        <label class="control__label">Должность</label>
                        <span class="control__required">*</span>
                    </div>
                    <span class="control__help">Это поле нужно заполнить</span>
                </div>
                <div class="control">
                    <div class="control__group">
                        <input type="text" id="work_phone" class="control__input" required />
                        <label class="control__label">Служебный номер с кодом города</label>
                        <span class="control__required">*</span>
                    </div>
                    <span class="control__help">Это поле нужно заполнить</span>
                </div>
                <div class="control">
                    <div class="control__group">
                        <input type="text" id="fax" class="control__input" required />
                        <label class="control__label">Факс с кодом города</label>
                        <span class="control__required">*</span>
                    </div>
                    <span class="control__help">Это поле нужно заполнить</span>
                </div>
                <div class="control">
                    <div class="control__group">
                        <input type="text" id="phone" class="control__input" required />
                        <label class="control__label">Мобильный телефон</label>
                        <span class="control__required">*</span>
                    </div>
                    <span class="control__help">Это поле нужно заполнить</span>
                </div>
                <div class="control">
                    <div class="control__group">
                        <input type="text" id="email" class="control__input" required />
                        <label class="control__label">Email</label>
                        <span class="control__required">*</span>
                    </div>
                    <span class="control__help">Это поле нужно заполнить</span>
                </div>
                <div class="control">
                    <div class="control__group">
                        <input type="text" id="city_name" class="control__input" required />
                        <label class="control__label">Город</label>
                        <span class="control__required">*</span>
                    </div>
                    <span class="control__help">Это поле нужно заполнить</span>
                </div>
                <div class="control">
                    <div class="control__group">
                        <input type="text" id="company_info" class="control__input" required />
                        <label class="control__label">Реквизиты компании</label>
                        <span class="control__required">*</span>
                    </div>
                    <span class="control__help">Это поле нужно заполнить</span>
                </div>
                <div class="control">
                    <div class="control__group">
                        <input type="text" id="director_name" class="control__input" required />
                        <label class="control__label">Ф.И.О и должность первого руководителя</label>
                        <span class="control__required">*</span>
                    </div>
                    <span class="control__help">Это поле нужно заполнить</span>
                </div>
                <div class="text-right">
                    <button type="button" onclick="buyByCashMagazine()" class="button -default register__button">Отправить</button>
                </div>
            </form>
        </div>
    </div>
</div>

