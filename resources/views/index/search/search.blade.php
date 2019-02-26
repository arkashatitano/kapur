@extends('index.layout.layout')

@section('meta-tags')

    <title>{{Lang::get('app.search')}}</title>

@endsection


@section('content')

    <main role="main" class="layout__main">

        <div class="page">
            <div class="container">

                <header class="page__header">
                    <h1 class="page__header-title">Поиск по сайту</h1>
                </header>

                <form class="search">
                    <button type="submit" class="button search__button">
                        <svg width="24" height="24" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.625 10.5H11.0325L10.8225 10.2975C11.5575 9.4425 12 8.3325 12 7.125C12 4.4325 9.8175 2.25 7.125 2.25C4.4325 2.25 2.25 4.4325 2.25 7.125C2.25 9.8175 4.4325 12 7.125 12C8.3325 12 9.4425 11.5575 10.2975 10.8225L10.5 11.0325V11.625L14.25 15.3675L15.3675 14.25L11.625 10.5ZM7.125 10.5C5.2575 10.5 3.75 8.9925 3.75 7.125C3.75 5.2575 5.2575 3.75 7.125 3.75C8.9925 3.75 10.5 5.2575 10.5 7.125C10.5 8.9925 8.9925 10.5 7.125 10.5Z"
                                  fill="#e2e2e2" />
                        </svg>
                    </button>
                    <div class="control">
                        <input type="search" name="q" class="control__input search__input" value="{{$request->q}}" placeholder="Введите ключевое слово">
                    </div>
                </form>

                <div class="docs">

                    @include('index.search.search-list-loop')

                </div>

            </div>
        </div>
    </main>


@endsection