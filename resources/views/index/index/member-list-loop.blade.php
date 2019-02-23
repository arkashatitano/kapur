<div class="section-heading">
    <h2 class="section-heading__title color-white">Члены ассоциации</h2>
    <div class="partners__controls">
        <div class="partners__prev jsPartnersPrev"></div>
        <div class="partners__next jsPartnersNext"></div>
    </div>
</div>
<div class="swiper-container jsPartnersSlider">
    <div class="swiper-wrapper">

        @foreach($member_list as $item)

            <div class="swiper-slide">
                <div class="partners__img">
                    <img src="{{$item['member_image']}}?width=100&height=100" title="{{$item['member_name_'.$lang]}}">
                </div>
            </div>

        @endforeach

    </div>
</div>