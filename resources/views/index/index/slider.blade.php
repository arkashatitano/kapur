<section class="pt-4 pt-md-5">
    <div class="container">
        <div class="entry">
            <div class="entry__inner">
                <div class="entry__content">
                    <div class="swiper-container entry__content-slider jsEntrySlider">
                        <div class="swiper-wrapper">

                            @foreach($slider_list as $item)

                                <div class="swiper-slide">
                                    <h1 class="entry__title">{{$item['slider_name_'.$lang]}}</h1>
                                    <div class="entry__text">{{$item['slider_text_'.$lang]}}</div>
                                    <a href="{{$item['slider_redirect']}}" class="button -underline_white entry__button">Подробнее</a>
                                </div>

                            @endforeach

                        </div>
                    </div>
                </div>
                <div class="swiper-container entry__img-slider jsImgSlider">
                    <div class="swiper-wrapper">

                        @foreach($slider_list as $item)

                            <div class="swiper-slide">
                                <img src="{{$item['slider_image']}}?width=750&height=680" alt="" class="entry__img">
                            </div>

                        @endforeach

                    </div>
                </div>
            </div>
            <div class="entry__controls">
                <div class="entry__prev jsEntryPrev"></div>
                <div class="swiper-pagination entry__pagination jsEntryPagination"></div>
                <div class="entry__next jsEntryNext"></div>
            </div>
        </div>
    </div>
</section>