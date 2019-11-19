@extends('index.layout.layout')

@section('meta-tags')

    <title>{{$menu['menu_meta_title_'.$lang]}}</title>
    <meta name="description" content="{{$menu['menu_meta_description_'.$lang]}}"/>
    <meta name="keywords" content="{{$menu['menu_meta_keywords_'.$lang]}}"/>

@endsection

@section('body')

@endsection


@section('content')

    <main role="main" class="layout__main">

        @include('index.index.slider')

        <!-- Blog Begin -->
        <section class="py-5">
            <div class="container">
                <div class="section-heading">
                    <h2 class="section-heading__title">Повышаем квалификацию</h2>
                </div>
                <div class="row" data-gutter="15" vertical-gutter="40">
                   @include('index.seminar.seminar-list-loop')
                </div>
            </div>
        </section>
        <!--/. Blog End -->

        <div class="divider"></div>

        <!-- Magazine Begin -->
        <section class="py-5">
            <div class="container">
                <div class="section-heading">
                    <h2 class="section-heading__title">Наш журнал</h2>
                    <a href="/magazines" class="button -underline section-heading__button">Все журналы</a>
                </div>
                <div class="row" data-gutter="15" vertical-gutter="40">
                    @include('index.magazine.magazine-list-loop')
                </div>
            </div>
        </section>
        <!--/. Magazine End -->

        <!-- Partners Begin -->
        <section class="partners py-5">
            <div class="container">

                @include('index.index.member-list-loop')

                @include('index.index.partner-list-loop')

            </div>
        </section>
        <!--/. Partners End -->

    </main>

@endsection