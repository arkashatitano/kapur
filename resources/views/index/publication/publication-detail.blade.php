@extends('index.layout.layout')

@section('meta-tags')

    <title>{{$publication['publication_name_'.$lang]}}</title>
    <meta name="description" content="{{$publication['publication_meta_description_'.$lang]}}"/>
    <meta name="keywords" content="{{$publication['publication_meta_keywords_'.$lang]}}"/>
    <meta property="og:title" content="{{$publication['publication_name_'.$lang]}}" />
    <meta property="og:description" content="{{$publication['publication_meta_description_'.$lang]}}" />
    <meta property="og:url" content="{{URL('/')}}/{{$publication['publication_url_'.$lang]}}" />
    <meta property="og:image" content="{{$publication->publication_image}}" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="500" />
    <meta property="og:image:height" content="500" />
    <link rel="image_src" href="{{$publication->publication_image}}" />
    
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
                        <a href="/articles" class="breadcrumbs__link">{{$menu['menu_name_'.$lang]}}</a>
                    </li>
                    <li class="breadcrumbs__item -active">{{$publication['publication_name_'.$lang]}}</li>
                </ul>

                <article class="article @if($publication->publication_price > 0) -demo @endif">
                    <header class="article__header -seminar">
                        <div class="article__date">{{\App\Http\Helpers::getDateFormat($publication->publication_date)}}</div>
                        <h1 class="article__title">{!! $publication['publication_name_'.$lang] !!}</h1>
                        <a href="#" class="button -underline_white article__button">Регистрация</a>
                        <div class="article__img">
                            <img src="{{$publication['publication_image']}}" alt="">
                        </div>
                    </header>
                    
                    <div class="article__body">
                        <div class="row">
                            <div class="col-lg-8">



                                @if($publication->publication_price == 0)

                                    <div>
                                        {!! $publication['publication_text_'.$lang] !!}
                                    </div>

                                    @if(\App\Http\Helpers::getInfoText(18) != '')
                                    <div class="article__info">
                                        {!! \App\Http\Helpers::getInfoText(18) !!}
                                    </div>
                                    @endif

                                @else

                                    <div>
                                        {!! substr($publication['publication_text_'.$lang], 0, 2100) !!}
                                    </div>

                                @endif

                            </div>
                            <div class="col-lg-4 order-lg-first">
                                <div class="article-social">
                                    <div class="article-social__title">Поделиться:</div>
                                    <div class="addthis_inline_share_toolbox_jy5t"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <!--/. Article End -->

            </section>
            <!--/. Container End -->

            @if($publication->publication_price > 0)
                <div class="divider mt-5"></div>
                <div class="subs">
                    <div class="container">
                        <h3 class="subs__title">Данная статья является платной и доступна только после покупки. Стоимость: {{$publication->publication_price}} тг.</h3>
                        <a href="#" class="button -underline_white">Купить статью</a>
                    </div>
                </div>
            @endif


            @if(count($other_publication_list) > 0)

                <div class="divider mt-5"></div>
                <section class="container pt-5">
                    <div class="section-heading">
                        <h2 class="section-heading__title">Статьи по теме</h2>
                    </div>
                    <div class="row" data-gutter="20" vertical-gutter="30">
                       @include('index.publication.publication-list-loop',['publication_list' => $other_publication_list])
                    </div>
                </section>

            @endif

        </div>
    </main>



@endsection

@section('js')
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5c98a5a402aee812"></script>
@endsection