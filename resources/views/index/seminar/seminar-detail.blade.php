@extends('index.layout.layout')

@section('meta-tags')

    <title>{{$seminar['seminar_name_'.$lang]}}</title>
    <meta name="description" content="{{$seminar['seminar_meta_description_'.$lang]}}"/>
    <meta name="keywords" content="{{$seminar['seminar_meta_keywords_'.$lang]}}"/>
    <meta property="og:title" content="{{$seminar['seminar_name_'.$lang]}}" />
    <meta property="og:description" content="{{$seminar['seminar_meta_description_'.$lang]}}" />
    <meta property="og:url" content="{{URL('/')}}/{{$seminar['seminar_url_'.$lang]}}" />
    <meta property="og:image" content="{{$seminar->seminar_image}}" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="500" />
    <meta property="og:image:height" content="500" />
    <link rel="image_src" href="{{$seminar->seminar_image}}" />
    
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
                        <a href="/seminar" class="breadcrumbs__link">{{$menu['menu_name_'.$lang]}}</a>
                    </li>
                    <li class="breadcrumbs__item -active">{{$seminar['seminar_name_'.$lang]}}</li>
                </ul>

                <article class="article">
                    <header class="article__header -seminar">
                        <div class="article__date">{{\App\Http\Helpers::getDateFormat($seminar->seminar_date)}}</div>
                        <h1 class="article__title">{!! $seminar['seminar_name_'.$lang] !!}</h1>
                        <a href="#" class="button -underline_white article__button">Регистрация</a>
                        <div class="article__img">
                            <img src="{{$seminar['seminar_image']}}" alt="">
                        </div>
                    </header>

                    <div class="article__body">
                        <div class="row">
                            <div class="col-lg-8">
                                <div>
                                    {!! $seminar['seminar_text_'.$lang] !!}
                                </div>

                                @if($seminar['seminar_desc_'.$lang] != '')
                                    <div class="article__info">
                                        {!! $seminar['seminar_desc_'.$lang] !!}
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



        </div>
    </main>



@endsection

@section('js')
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ae235148e8f7f04"></script>
@endsection