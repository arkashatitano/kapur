@extends('index.layout.layout')

@section('meta-tags')

    <title>{{Lang::get('app.search')}}</title>

@endsection


@section('content')

    <main role="main" class="layout__main">
        <div class="page">
            <header class="page__header">
                <div class="container">
                    <ul class="breadcrumbs">
                        <li class="breadcrumbs__item">
                            <a href="/" class="breadcrumbs__link">{{Lang::get('app.homepage')}}</a>
                        </li>
                        <li class="breadcrumbs__item">{{Lang::get('app.search')}}</li>
                    </ul>
                    <h1 class="page__header-title">{{Lang::get('app.search')}}</h1>
                </div>
            </header>
            <div class="page__content">
                <div class="container">
                    <div>
                        <p>{{Lang::get('app.find_result')}} {{count($news_list) + count($menu_list) + count($arbitrator_list) }} {{Lang::get('app.materials')}}</p>
                    </div>
                    @include('index.search.search-list-loop')
                </div>
                <div class="page__divider"></div>
            </div>
        </div>
    </main>

@endsection