<?php


/******* Admin page *******/
Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => 'web'
], function() {

    Route::any('/login', 'AuthController@login');
    Route::get('/logout', 'AuthController@logout');

    Route::post('partner/is_show', 'PartnerController@changeIsShow');
    Route::resource('partner', 'PartnerController');

    Route::post('member/is_show', 'MemberController@changeIsShow');
    Route::resource('member', 'MemberController');

    Route::post('info/is_show', 'InfoController@changeIsShow');
    Route::resource('info', 'InfoController');

    Route::post('seminar/is_show', 'SeminarController@changeIsShow');
    Route::resource('seminar', 'SeminarController');

    Route::post('video/is_show', 'VideoController@changeIsShow');
    Route::resource('video', 'VideoController');

    Route::post('gallery/is_show', 'GalleryController@changeIsShow');
    Route::get('gallery/image', 'GalleryController@getImageList');
    Route::resource('gallery', 'GalleryController');

    Route::post('news/is_show', 'NewsController@changeIsShow');
    Route::resource('news', 'NewsController');

    Route::post('magazine/is_show', 'MagazineController@changeIsShow');
    Route::get('magazine/image', 'MagazineController@getDocumentList');
    Route::resource('magazine', 'MagazineController');

    Route::post('expert/is_show', 'ExpertController@changeIsShow');
    Route::resource('expert', 'ExpertController');

    Route::post('menu/is_show', 'MenuController@changeIsShow');
    Route::resource('menu', 'MenuController');

    Route::post('certificate/is_show', 'CertificateController@changeIsShow');
    Route::resource('certificate', 'CertificateController');

    Route::post('document/is_show', 'DocumentController@changeIsShow');
    Route::resource('document', 'DocumentController');

    Route::post('publication/is_show', 'PublicationController@changeIsShow');
    Route::resource('publication', 'PublicationController');

    Route::post('category/is_show', 'CategoryController@changeIsShow');
    Route::resource('category', 'CategoryController');

    Route::post('slider/is_show', 'SliderController@changeIsShow');
    Route::resource('slider', 'SliderController');

    Route::post('order/is_show', 'OrderController@changeIsShow');
    Route::resource('order', 'OrderController');

    Route::post('subscription/is_show', 'SubscriptionController@changeIsShow');
    Route::resource('subscription', 'SubscriptionController');

    Route::get('user/reset/{id}', 'UsersController@resetPassword');
    Route::post('user/is_show', 'UsersController@changeIsBan');
    Route::resource('user', 'UsersController');
    Route::any('password', 'UsersController@password');

    Route::get('index', 'IndexController@index');
});


/******* Main page *******/
Route::group([
    'middleware' => 'web'
], function() {
    Route::post('image/upload', 'ImageController@uploadImage');
    Route::post('image/upload/file', 'ImageController@uploadFile');
    Route::get('media/{file_name}', 'ImageController@getImage')->where('file_name', '.*');
    Route::get('file/{file_name}', 'ImageController@showFile')->where('file_name','.*');
});


/******* Index *******/
Route::group([
    'middleware' => 'web',
    'namespace' => 'Index',
], function() {

    Route::post('ajax/register', 'SeminarController@register');

    Route::get('/', 'IndexController@index');

    Route::get('contact', 'IndexController@showContact');

    Route::get('subscription', 'IndexController@showSubscription');

    Route::get('documents', 'DocumentController@showDocumentList');

    Route::get('certificate', 'CertificateController@showCertificateList');

    Route::get('news', 'NewsController@showNewsList');
    Route::get('news/{url}', 'NewsController@showNewsById');

    Route::get('articles', 'PublicationController@showPublicationList');
    Route::get('article/{url}', 'PublicationController@showPublicationById');

    Route::get('video', 'VideoController@showVideoList');
    Route::get('video/{url}', 'VideoController@showVideoById');

    Route::get('magazines', 'MagazineController@showMagazineList');
    Route::get('magazine/{url}', 'MagazineController@showMagazineById');

    Route::get('seminar', 'SeminarController@showSeminarList');
    Route::get('seminar/{url}', 'SeminarController@showSeminarById');

    Route::get('gallery', 'GalleryController@showGalleryList');
    Route::get('gallery/{url}', 'GalleryController@showGalleryById');

    Route::get('{url}', 'PageController@showPage');


    
});