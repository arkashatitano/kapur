<div class="modal -wide" tabindex="-1" role="dialog" id="modal-register">
    <div class="modal-dialog" role="document">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&#10005;</span>
        </button>
        <div class="modal__inner">
            <form class="register">
                <div class="h1 mb-4 mb-md-5">Регистрация</div>
                <div class="control">
                    <div class="control__group">
                        <input type="hidden" id="seminar_id" value="{{$seminar['seminar_id']}}"/>
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
                <div class="control">
                    <div class="control__row">
                        <div class="control__inputs-title">Форма оплаты:</div>
                        <div class="control__input-group">
                            <div class="mb-2 mb-sm-0 mr-3">
                                <input class="with-gap pay_type" checked name="pay_type" value="наличными" type="radio" id="test3" />
                                <label for="test3">наличными</label>
                            </div>
                            <div>
                                <input class="with-gap pay_type" name="pay_type" value="по перечислению" type="radio" id="test4" />
                                <label for="test4">по перечислению</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="button" onclick="addRegister()" class="button -default register__button">Отправить</button>
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