@extends('index.layout.layout')

@section('meta-tags')

    <title>{{$menu['menu_meta_title_'.$lang]}}</title>
    <meta name="description" content="{{$menu['menu_meta_description_'.$lang]}}"/>
    <meta name="keywords" content="{{$menu['menu_meta_keywords_'.$lang]}}"/>
    <meta property="og:title" content="{{$menu['menu_meta_title_'.$lang]}}" />
    <meta property="og:description" content="{{$menu['menu_meta_description_'.$lang]}}" />

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

                    @if($menu->parent_name != '')
                        <li class="breadcrumbs__item">
                            <a href="#" class="breadcrumbs__link">@lang('app.about_us')</a>
                        </li>
                    @endif

                    <li class="breadcrumbs__item -active">{{$menu['menu_name_'.$lang]}}</li>
                </ul>

                <article class="article">
                    <header class="article__header1">
                        <h1 class="page__header-title">{{$menu['menu_name_'.$lang]}}</h1>
                        @if()
                        @endif
                    </header>
                    <div class="article__body">
                        <div class="row" data-gutter="50">
                            <div class="col-lg-12">
                                {!! $menu['menu_text_'.$lang] !!}

                                @if(isset($document_list) && count($document_list) > 0)

                                    <div class="article__info">
                                        <p>@lang('app.download')</p>

                                        @foreach($document_list as $key => $item)
                                            <div class="mb-10">
                                                {{$key+1}}. <a target="_blank" href="{{$item->file_url}}">{{$item['file_name_ru']}}</a>
                                            </div>

                                        @endforeach

                                    </div>

                                @endif

                            </div>
                        </div>
                    </div>
                </article>

            </section>


        </div>
    </main>



@endsection

@section('js')


@endsection
