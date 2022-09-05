@extends('index.layout.layout')

@section('meta-tags')

    <title>{{$magazine['magazine_name_'.$lang]}}</title>
    <meta name="description" content="{{$magazine['magazine_meta_description_'.$lang]}}"/>
    <meta name="keywords" content="{{$magazine['magazine_meta_keywords_'.$lang]}}"/>
    <meta property="og:title" content="{{$magazine['magazine_name_'.$lang]}}" />
    <meta property="og:description" content="{{$magazine['magazine_meta_description_'.$lang]}}" />
    <meta property="og:url" content="{{URL('/')}}/{{$magazine['magazine_url_'.$lang]}}" />
    <meta property="og:image" content="{{URL('/')}}{{$magazine->magazine_image}}" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="500" />
    <meta property="og:image:height" content="500" />
    <link rel="image_src" href="{{$magazine->magazine_image}}" />
    
@endsection


@section('content')

    <main role="main" class="layout__main">
        <div class="page">
            <section class="container">
                <ul class="breadcrumbs">
                    <li class="breadcrumbs__item -back">
                        <a href="/" class="breadcrumbs__link">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 11.0001H7.83L13.42 5.41006L12 4.00006L4 12.0001L12 20.0001L13.41 18.5901L7.83 13.0001H20V11.0001Z" fill="#218F44" />
                            </svg>
                            Назад
                        </a>
                    </li>

                    <li class="breadcrumbs__item">
                        <a href="/" class="breadcrumbs__link">{{Lang::get('app.homepage')}}</a>
                    </li>
                    <li class="breadcrumbs__item">
                        <a href="/magazines" class="breadcrumbs__link">{{$menu['menu_name_'.$lang]}}</a>
                    </li>
                    <li class="breadcrumbs__item -active">{{$magazine['magazine_name_'.$lang]}}</li>
                </ul>

                <article class="article">
                    <header class="article__header -magazine">
                        <div class="article__date">{!! $magazine['magazine_number'] !!}</div>
                        <h1 class="article__title" @if($magazine['text_color'] != '') style="color:{{$magazine['text_color']}}" @endif>{!! $magazine['magazine_name_'.$lang] !!}</h1>

                        @if($magazine->magazine_price > 0)
                            <a href="#modal-pay" class="button -underline_white article__button" data-gutter="#modal-pay" data-toggle="modal">@lang('app.buy')</a>
                        @endif

                        <div class="article__img">
                            <img src="{{$magazine['magazine_image']}}" alt="">
                        </div>
                    </header>

                    <div class="article__body">
                        <div class="row">
                            <div class="col-lg-8">

                                @if(isset($document_list) && count($document_list) > 0)

                                    <div class="article__info mb-20">
                                        <p>@lang('app.download')</p>

                                        @foreach($document_list as $key => $item)

                                                <div class="mb-10">
                                                    {{$key+1}}. <a target="_blank" href="{{$item->file_url}}">{{$item['file_name_ru']}}</a>
                                                </div>

                                        @endforeach

                                    </div>

                                @endif

                                <div>
                                    {!! $magazine['magazine_text_'.$lang] !!}
                                </div>

                                @if($magazine['magazine_desc_'.$lang] != '')
                                    <div class="article__info">
                                        {!! $magazine['magazine_desc_'.$lang] !!}
                                    </div>
                                @endif

                                @if($magazine->magazine_price > 0)

                                    <div>
                                        <strong>
                                            <span style="color:#003399; font-size: 16px">Подписку на журнал Вы можете оформить:</span>
                                        </strong>
                                        <ol class="fancy_list">
                                            <li>В любом отделении АО "Казпочта", индекс подписного издания 75180, <br> Основной Каталог подписных изданий. (для физических и юридических лиц)</li>
                                            <li>Оформить подписку на сайте <a href="http://www.postmarket.kz/">http://www.postmarket.kz/</a>, (для физических лиц)</li>
                                            <li><a class="ke-insertfile" href="/custom/wysiwyg/image/file/20200528/20200528172943_47050.docx" target="_blank">По договору</a> (для юридических лиц)</li>
                                        </ol>
                                        <a href="#modal-pay" type="button" class="button -default -md " data-toggle="modal" data-gutter="#modal-pay">@lang('app.buy')</a>
                                    </div>
                                @endif

                            </div>
                            <div class="col-lg-4 order-lg-first">
                                <div class="article-social">
                                    <div class="article-social__title">Поделиться:</div>
                                    <div class="addthis_inline_share_toolbox"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <!--/. Article End -->

            </section>
            <!--/. Container End -->
            @if($magazine->magazine_price > 0)

                @include('index.magazine.pay-modal')


            @endif

        </div>
    </main>



@endsection

@section('js')
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5d3942e8649f2396"></script>
@endsection