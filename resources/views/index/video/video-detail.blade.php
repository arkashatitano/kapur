@extends('index.layout.layout')

@section('meta-tags')

    <title>{{$video['video_name_'.$lang]}}</title>
    <meta name="description" content="{{$video['video_meta_description_'.$lang]}}"/>
    <meta name="keywords" content="{{$video['video_meta_keywords_'.$lang]}}"/>
    <meta property="og:title" content="{{$video['video_name_'.$lang]}}" />
    <meta property="og:description" content="{{$video['video_meta_description_'.$lang]}}" />
    <meta property="og:url" content="{{URL('/')}}/{{$video['video_url_'.$lang]}}" />
    <meta property="og:image" content="{{$video->video_image}}" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="500" />
    <meta property="og:image:height" content="500" />
    <link rel="image_src" href="{{$video->video_image}}" />
    
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
                        <a href="/video" class="breadcrumbs__link">{{$menu['menu_name_'.$lang]}}</a>
                    </li>
                    <li class="breadcrumbs__item -active">{{$video['video_name_'.$lang]}}</li>
                </ul>

                <article class="article">
                    <header class="article__header">
                        <div class="article__date">{{\App\Http\Helpers::getDateFormat($video->video_date)}}</div>
                        <h1 class="article__title"> {!! $video['video_name_'.$lang] !!}</h1>
                    </header>
                    <div class="article__body">
                        <div class="row">
                            <div class="col-lg-8">
                                <div>
                                    {!! $video['video_text_'.$lang] !!}
                                </div>

                                @if($video['video_url'] != '')

                                    <?php $video['video_url'] = str_replace('watch?v=','embed/',$video['video_url']); ?>

                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe class="embed-responsive-item" src="{{$video['video_url']}}" allowfullscreen></iframe>
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

            @if(count($other_video_list) > 0)

                <div class="divider mt-5"></div>
                <section class="container pt-5">
                    <div class="section-heading">
                        <h2 class="section-heading__title">Новости по теме</h2>
                    </div>
                    <div class="row" data-gutter="20" vertical-gutter="30">
                       @include('index.video.video-list-loop',['video_list' => $other_video_list])
                    </div>
                </section>

            @endif

        </div>
    </main>



@endsection

@section('js')
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ae235148e8f7f04"></script>
@endsection