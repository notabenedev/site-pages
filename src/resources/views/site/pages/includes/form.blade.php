<form class="sending-form-custom position-relative" name="page-order-form">
    @hiddenCaptcha
    <div class="form-row">
        <div class="col-12">
            <div class="form-group">
                <label for="name{{ isset($modal) ?: "-full" }}">Имя <span class="text-danger">*</span></label>
                <input type="text"
                       id="name{{ isset($modal) ?: "-full" }}"
                       name="name"
                       required
                       class="form-control">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="phone{{ isset($modal) ?: "-full" }}">Номер телефона <span class="text-danger">*</span></label>
                <input type="text"
                       id="phone{{ isset($modal) ?: "-full" }}"
                       name="phone"
                       required
                       class="form-control">
            </div>
        </div>

        @if (config("site-pages.sitePageShowFormInputDate"))
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="date{{ isset($modal) ?: "-full" }}">{{ config("site-pages.sitePageShowFormInputDate") }} <span class="text-danger">*</span></label>
                    <input type="date"
                           id="date{{ isset($modal) ?: "-full" }}"
                           name="date"
                           required
                           class="form-control">
                </div>
            </div>
        @endif
        @if (config("site-pages.sitePageShowFormInputTitle"))
            <div class="col-12 {{ config("site-pages.sitePageShowFormInputDate")? "col-md-6" : "" }}">
                <div class="form-group">
                    <label for="title{{ isset($modal) ?: "-full" }}">{{ config("site-pages.sitePageShowFormInputTitle") }} <span class="text-danger">*</span></label>
                    <input type="text"
                           id="title{{ isset($modal) ?: "-full" }}"
                           name="title"
                           value="{{ $title }}"
                           required
                           disabled
                           class="form-control">
                    <input type="hidden"
                           id="folder{{ isset($modal) ?: "-full" }}"
                           name="folder"
                           value="{{ $folder }}"
                           required
                           class="form-control">
                </div>
            </div>
        @endif
        <div class="col-12">
            <div class="form-group">
                <label for="message{{ isset($modal) ?: "-full" }}">Комментарий</label>
                <textarea class="form-control" name="message" id="message{{ isset($modal) ?: "-full" }}" rows="3">{{ old('message') }}</textarea>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox"
                           class="custom-control-input"
                           id="privacy_policy{{ isset($modal) ?: "-full" }}"
                           checked
                           required
                           name="privacy_policy">
                    <label class="custom-control-label" for="privacy_policy{{ isset($modal) ?: "-full" }}">Согласие с <a href="{{ route("policy") }}" target="_blank" > "Политикой конфиденциальности"</a></label>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="btn-group"
                 role="group">
                <button type="submit" class="btn btn-primary">Заказать</button>
            </div>
        </div>
    </div>
</form>