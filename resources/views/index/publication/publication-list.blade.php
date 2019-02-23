@extends('index.layout.layout')

@section('meta-tags')

    <title>{{$menu['menu_meta_title_'.$lang]}}</title>
    <meta name="description" content="{{$menu['menu_meta_description_'.$lang]}}"/>
    <meta name="keywords" content="{{$menu['menu_meta_keywords_'.$lang]}}"/>

@endsection


@section('content')

    <main role="main" class="layout__main">
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
                    <li class="breadcrumbs__item -active">{{$menu['menu_name_'.$lang]}}</li>
                </ul>

                <header class="page__header">
                    <h1 class="page__header-title">{{$menu['menu_name_'.$lang]}}</h1>
                </header>

                <div class="links">
                    <a href="/articles" class="links__item @if(!isset($_GET['category'])) -active @endif">все</a>

                    @foreach($category_list as $item)
                        <a href="/articles?category={{$item->category_id}}" class="links__item  @if(isset($_GET['category']) && ($_GET['category'] == $item->category_id)) -active @endif">{{$item['category_name_'.$lang]}}</a>
                    @endforeach

                </div>

                <div class="row" data-gutter="20" vertical-gutter="30">

                    @include('index.publication.publication-list-loop')

                </div>

                <div class="text-center p-30">
                    {!! $publication_list->links() !!}
                </div>

            </div>
        </div>
    </main>


@endsection