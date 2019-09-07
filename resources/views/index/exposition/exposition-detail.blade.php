@extends('index.layout.layout')

@section('meta-tags')

    <title>{{$exposition['exposition_name_'.$lang]}}</title>
    <meta name="description" content="{{$exposition['exposition_meta_description_'.$lang]}}"/>
    <meta name="keywords" content="{{$exposition['exposition_meta_keywords_'.$lang]}}"/>
    <meta property="og:title" content="{{$exposition['exposition_name_'.$lang]}}" />
    <meta property="og:description" content="{{$exposition['exposition_meta_description_'.$lang]}}" />
    <meta property="og:url" content="{{URL('/')}}/{{$exposition['exposition_url_'.$lang]}}" />
    <meta property="og:image" content="{{URL('/')}}{{$exposition->exposition_image}}" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="500" />
    <meta property="og:image:height" content="500" />
    <link rel="image_src" href="{{$exposition->exposition_image}}" />
    
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
                        <a href="/exposition" class="breadcrumbs__link">{{$menu['menu_name_'.$lang]}}</a>
                    </li>
                    <li class="breadcrumbs__item -active">{{$exposition['exposition_name_'.$lang]}}</li>
                </ul>

                <article class="article">
                    <header class="article__header">
                        <div class="article__date">{{\App\Http\Helpers::getDateFormat3($exposition->exposition_date)}}</div>
                        <h1 class="article__title" @if($exposition['text_color'] != '') style="color:{{$exposition['text_color']}}" @endif> {!! $exposition['exposition_name_'.$lang] !!}</h1>
                    </header>
                    <div class="article__body">
                        <div class="row">
                            <div class="col-lg-8">
                                <div>
                                    {!! $exposition['exposition_text_'.$lang] !!}
                                </div>

                                @if($exposition->exposition_pdf != '')

                                    <div class="article__info">
                                        <p>Прикрепленные файлы</p>
                                        <a target="_blank" href="{{$exposition->exposition_pdf}}">Скачать файл</a>
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

        </div>
    </main>



@endsection

@section('js')
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5d3942e8649f2396"></script>
@endsection