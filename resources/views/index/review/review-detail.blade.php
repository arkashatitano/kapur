@extends('index.layout.layout')

@section('meta-tags')

    <title>{{$review['review_name_'.$lang]}}</title>
    <meta name="description" content="{{$review['review_meta_description_'.$lang]}}"/>
    <meta name="keywords" content="{{$review['review_meta_keywords_'.$lang]}}"/>
    <meta property="og:title" content="{{$review['review_name_'.$lang]}}" />
    <meta property="og:description" content="{{$review['review_meta_description_'.$lang]}}" />
    <meta property="og:url" content="{{URL('/')}}/{{$review['review_url_'.$lang]}}" />
    <meta property="og:image" content="{{URL('/')}}{{$review->review_image}}" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="500" />
    <meta property="og:image:height" content="500" />
    <link rel="image_src" href="{{$review->review_image}}" />
    
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
                        <a href="/review" class="breadcrumbs__link">{{$menu['menu_name_'.$lang]}}</a>
                    </li>
                    <li class="breadcrumbs__item -active">{{$review['review_name_'.$lang]}}</li>
                </ul>

                <article class="article">
                    <header class="article__header">
                        <div class="article__date">{{\App\Http\Helpers::getDateFormat3($review->review_date)}}</div>
                        <h1 class="article__title"> {!! $review['review_name_'.$lang] !!}</h1>
                    </header>
                    <div class="article__body">
                        <div class="row">
                            <div class="col-lg-8">
                                <div>
                                    {!! $review['review_text_'.$lang] !!}
                                </div>

                                @if($review->review_pdf != '')

                                    <div class="article__info">
                                        <p>Файлы для скачивания</p>
                                        <a target="_blank" href="{{$review->review_pdf}}">Скачать файл</a>
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