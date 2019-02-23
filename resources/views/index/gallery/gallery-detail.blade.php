@extends('index.layout.layout')

@section('meta-tags')

    <title>{{$gallery['gallery_name_'.$lang]}}</title>
    <meta name="description" content="{{$gallery['gallery_meta_description_'.$lang]}}"/>
    <meta name="keywords" content="{{$gallery['gallery_meta_keywords_'.$lang]}}"/>
    <meta property="og:title" content="{{$gallery['gallery_name_'.$lang]}}" />
    <meta property="og:description" content="{{$gallery['gallery_meta_description_'.$lang]}}" />
    <meta property="og:url" content="{{URL('/')}}/{{$gallery['gallery_url_'.$lang]}}" />
    <meta property="og:image" content="{{$gallery->gallery_image}}" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="500" />
    <meta property="og:image:height" content="500" />
    <link rel="image_src" href="{{$gallery->gallery_image}}" />
    
@endsection


@section('content')

    <main role="main" class="layout__main">

        <!-- Page Begin -->
        <div class="page">
            <div class="container">

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
                        <a href="/gallery" class="breadcrumbs__link">{{$menu['menu_name_'.$lang]}}</a>
                    </li>
                    <li class="breadcrumbs__item -active">{{$gallery['gallery_name_'.$lang]}}</li>
                </ul>
                
                <header class="page__header">
                    <h1 class="page__header-title">{{$gallery['gallery_name_'.$lang]}}</h1>
                </header>
               
                <div class="row lg" data-gutter="20" vertical-gutter="30">

                    @foreach($image_list as $item)

                        <div class="col-md-6 col-lg-4 lg__item" data-src="{{$item['image_url']}}">
                            <div class="blog">
                                <a href="#" class="blog__img">
                                    <img src="{{$item['image_url']}}?width=360&height=250" alt="">
                                </a>
                            </div>
                        </div>

                    @endforeach
                    
                </div>
                

            </div>
        </div>
        <!--/. Page End -->

    </main>



@endsection

