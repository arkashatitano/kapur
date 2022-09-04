<div class="section-heading mt-5">
    <h2 class="section-heading__title color-white">@lang('app.our_partners')</h2>
    <div class="partners__controls">
        <div class="partners__prev jsPartnersPrev2"></div>
        <div class="partners__next jsPartnersNext2"></div>
    </div>
</div>
<div class="swiper-container jsPartnersSlider2">
    <div class="swiper-wrapper">

        @foreach($partner_list as $item)

            <div class="swiper-slide">
                <div class="partners__img">
                    <img src="{{$item['partner_image']}}?width=100&height=100" title="{{$item['partner_name_'.$lang]}}">
                </div>
            </div>

        @endforeach

    </div>
</div>