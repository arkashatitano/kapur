
<div class="modal -wide" tabindex="-1" role="dialog" id="pay-information">
    <div class="modal-dialog" role="document">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&#10005;</span>
        </button>
        <div class="modal__inner">
            <form class="register">
                <div class="h1 mb-4 mb-md-5">Купить статью</div>
                <div class="control">
                    <div class="control__group">
                        <input type="text" id="user_name" class="control__input" required />
                        <label class="control__label">ФИО</label>
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
                <div class="text-right">
                    <button type="button" onclick="buyArticle()" class="button -default register__button">Отправить</button>
                </div>
            </form>
        </div>
    </div>
</div>

