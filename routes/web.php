<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{
    Route::group(['middleware' => ['web']], function () {
        /* Pages */
        Route::name('home')->get('/', 'HomeController@index');
        if(app()->getLocale() == 'tr'){
            Route::name('about')->get('/hakkimizda', 'HomeController@about');
        }else{
            Route::name('about')->get('/about', 'HomeController@about');
        }
        if(app()->getLocale() == 'tr'){
            Route::name('bth')->get('/bilgitoplumuhizmetleri', 'HomeController@bth');
        }else{
            Route::name('bth')->get('/bilgitoplumuhizmetleri', 'HomeController@bth');
        }
        if(app()->getLocale() == 'tr'){
            Route::name('hr')->get('/kariyer', 'HomeController@hr');
            Route::name('hr.detail')->get('/kariyer/{url}', 'HomeController@hrDetail');
        }else{
            Route::name('hr')->get('/career', 'HomeController@hr');
            Route::name('hr.detail')->get('/career/{url}', 'HomeController@hrDetail');
        }
        if(app()->getLocale() == 'tr'){
            Route::name('contact')->get('/iletisim', 'HomeController@contact');
        }else{
            Route::name('contact')->get('/contact', 'HomeController@contact');
        }
        if(app()->getLocale() == 'tr'){
            Route::name('quality-management')->get('/kalite-yonetimi', 'HomeController@qualityManagement');
        }else{
            Route::name('quality-management')->get('/quality-management', 'HomeController@qualityManagement');
        }
        if(app()->getLocale() == 'tr'){
            Route::name('download-center')->get('/indirme-merkezi', 'HomeController@downloadCenter');
        }else{
            Route::name('download-center')->get('/download-center', 'HomeController@downloadCenter');
        }

        if(app()->getLocale() == 'tr'){
            Route::name('media-hub')->get('/dosya-arsivi', 'HomeController@mediaHub');
        }else{
            Route::name('media-hub')->get('/media-hub', 'HomeController@mediaHub');
        }

        if(app()->getLocale() == 'tr'){
            Route::name('tire-curing-molds')->get('/tire-curing-molds', 'HomeController@tireCuringMolds');
        }else{
            Route::name('tire-curing-molds')->get('/tire-curing-molds', 'HomeController@tireCuringMolds');
        }
        if(app()->getLocale() == 'tr'){
            Route::name('tire-curing-presses')->get('/tire-curing-presses', 'HomeController@tireCuringPresses');
        }else{
            Route::name('tire-curing-presses')->get('/tire-curing-presses', 'HomeController@tireCuringPresses');
        }

        if(app()->getLocale() == 'tr'){
            Route::name('articles.index')->get('/haberler', 'ArticlesController@index');
            Route::name('articles.detail')->get('/haberler/{url}', 'ArticlesController@detail');
        }else{
            Route::name('articles.index')->get('/news', 'ArticlesController@index');
            Route::name('articles.detail')->get('/news/{url}', 'ArticlesController@detail');
        }

        Route::name('validate-mailgun')->get('/validate-mailgun/{email}', 'ValidationController@validateMailgun');
        /*Mails*/
        Route::name('mail.contact')->post('/contact', 'EmailController@contact');
        Route::name('mail.job')->post('/job', 'EmailController@job');
        Route::name('mail.quote')->post('/quote', 'EmailController@quote');
        Route::name('mail.request-offer')->post('/request-offer', 'EmailController@offer');
    });
});

Auth::routes();

Route::group(['prefix' => LaravelLocalization::setLocale()], function(){
    Route::prefix(config('app.cms_path'))->middleware('auth')->as('cms.')->namespace('Cms')->group(function(){
        Route::name('home')->get('/home', 'HomeController@index');
        Route::name('search')->get('/search', 'SearchController@search');
        Route::name('change-settings')->post('/settings', 'UserProfileController@changeSettings');
        Route::name('change-profile-photo.index')->get('/change-profile-photo', 'UserProfileController@changeProfilePhoto');
        Route::name('change-profile-photo.store')->post('/change-profile-photo', 'UserProfileController@storeProfilePhoto');

        Route::name('tasks.index')->get('/tasks', 'TasksController@index');
        Route::name('tasks.store')->post('/tasks', 'TasksController@store');
        Route::name('tasks.update')->post('/tasks/update', 'TasksController@update');
        Route::name('tasks.fetch')->get('/tasks/fetch', 'TasksController@fetch');
        Route::name('tasks.order')->post('/tasks/order', 'TasksController@order');
        Route::name('tasks.orderCompleted')->post('/tasks/orderCompleted', 'TasksController@orderCompleted');

        Route::prefix('user-management')->as('user-management.')->namespace('UserManagement')->group(function(){
            Route::name('roles.index')->get('/roles', 'RolesController@index');
            Route::name('roles.store')->post('/roles', 'RolesController@store');
            Route::name('roles.create')->get('/roles/create', 'RolesController@create');
            Route::name('roles.edit')->get('/roles/{role}/edit', 'RolesController@edit');
            Route::name('roles.update')->put('/roles/{role}', 'RolesController@update');
            Route::name('roles.delete')->delete('/roles/{role}', 'RolesController@delete');

            Route::name('permissions.index')->get('/permissions', 'PermissionsController@index');
            Route::name('permissions.create')->get('/permissions/create', 'PermissionsController@create');
            Route::name('permissions.store')->post('/permissions', 'PermissionsController@store');
            Route::name('permissions.edit')->get('/permissions/{permission}/edit', 'PermissionsController@edit');
            Route::name('permissions.update')->put('/permissions/{permission}', 'PermissionsController@update');
            Route::name('permissions.delete')->delete('/permissions/{permission}', 'PermissionsController@delete');

            Route::name('users.index')->get('/users', 'UsersController@index');
            Route::name('users.store')->post('/users', 'UsersController@store');
            Route::name('users.create')->get('/users/create', 'UsersController@create');
            Route::name('users.edit')->get('/users/{user}/edit', 'UsersController@edit');
            Route::name('users.update')->put('/users/{user}', 'UsersController@update');
            Route::name('users.delete')->delete('/users/{invitee}', 'UsersController@delete');
            Route::name('users.ban')->put('/users/{user}/ban', 'UsersController@ban');
            Route::name('users.reactivate')->put('/users/{user}/reactivate', 'UsersController@reactivate');
        });

        Route::prefix('forms')->as('forms.')->namespace('Forms')->group(function(){
            Route::name('index')->get('/', 'FormsController@index');
            Route::name('store')->post('/', 'FormsController@store');
            Route::name('create')->get('/create', 'FormsController@create');
            Route::name('edit')->get('/{form}/edit', 'FormsController@edit');
            Route::name('update')->put('/{form}', 'FormsController@update');
            Route::name('delete')->delete('/{form}', 'FormsController@delete');

            Route::name('categories.store')->post('/categories', 'CategoriesController@store');
            Route::name('categories.create')->get('/categories/{form}/create', 'CategoriesController@create');
            Route::name('categories.edit')->get('/categories/{category}/edit', 'CategoriesController@edit');
            Route::name('categories.update')->put('/categories/{category}', 'CategoriesController@update');
            Route::name('categories.delete')->delete('/categories/{category}', 'CategoriesController@delete');
        });

        Route::prefix('inbox')->as('inbox.')->namespace('Inbox')->group(function(){
            Route::name('index')->get('/', 'InboxController@index');
            Route::name('sent')->get('/sent', 'InboxController@sent');
            Route::name('trash')->get('/trash', 'InboxController@trash');
            Route::name('important')->get('/important', 'InboxController@important');
            Route::name('drafts')->get('/drafts', 'InboxController@drafts');
            Route::name('form')->get('/form/{form}', 'InboxController@form');
            Route::name('category')->get('/category/{category}', 'InboxController@category');
            Route::name('detail')->get('/{mail}/detail', 'InboxController@detail');
            Route::name('edit')->get('/{mail}/edit', 'InboxController@edit');
            Route::name('reply')->get('/{mail}/reply', 'InboxController@reply');
            Route::name('compose')->get('/compose', 'InboxController@compose');
            Route::name('search')->get('/search', 'InboxController@search');

            Route::name('send')->post('/send', 'InboxController@send');
            Route::name('save-draft')->post('/save-draft', 'InboxController@saveDraft');
            Route::name('update')->post('/{mail}/update', 'InboxController@update');
            Route::name('delete')->put('/delete', 'InboxController@delete');
            Route::name('discard')->delete('/discard', 'InboxController@discard');
            Route::name('mark-as-important')->post('/mark-as-important', 'InboxController@markAsImportant');
            Route::name('mark-as-read')->post('/mark-as-read', 'InboxController@markAsRead');
            Route::name('mark-as-trash')->post('/mark-as-trash', 'InboxController@markAsTrash');
            Route::name('move-to-trash')->post('/{mail}/move-to-trash', 'InboxController@moveToTrash');
        });

        Route::prefix('file-manager')->as('file-manager.')->namespace('FileManager')->group(function(){
            Route::name('index')->get('/', 'FileManagerController@index');
            Route::name('store')->post('/', 'FileManagerController@store');
            Route::name('detail')->get('/{folder}/detail', 'FileManagerController@detail');
            Route::name('delete')->delete('/{file}', 'FileManagerController@delete');
            Route::name('categories.store')->post('/categories', 'CategoriesController@store');
        });

        Route::prefix('articles')->as('articles.')->namespace('Articles')->group(function(){
            Route::name('index')->get('/', 'ArticlesController@index');
            Route::name('store')->post('/', 'ArticlesController@store');
            Route::name('create')->get('/create', 'ArticlesController@create');
            Route::name('sort')->get('/sort', 'ArticlesController@sort');
            Route::name('sort-records')->post('/sort-records', 'ArticlesController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'ArticlesController@edit');
            Route::name('update')->put('/{record}', 'ArticlesController@update');
            Route::name('delete')->delete('/{record}', 'ArticlesController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'ArticlesController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'ArticlesController@togglePromotion');

            Route::name('gallery')->get('/{record}/gallery', 'GalleryController@index');
            Route::name('gallery.edit')->get('/gallery/{record}/edit', 'GalleryController@edit');
            Route::name('gallery.update')->put('/gallery/{record}', 'GalleryController@update');
            Route::name('gallery.store')->post('/gallery', 'GalleryController@store');
            Route::name('gallery.delete')->delete('/gallery/{record}/delete', 'GalleryController@delete');
            Route::name('gallery.sort-records')->post('/gallery/sort-records', 'GalleryController@sortRecords');
        });

        Route::prefix('employees')->as('employees.')->namespace('Employees')->group(function(){
            Route::name('index')->get('/', 'EmployeesController@index');
            Route::name('store')->post('/', 'EmployeesController@store');
            Route::name('create')->get('/create', 'EmployeesController@create');
            Route::name('sort')->get('/sort', 'EmployeesController@sort');
            Route::name('sort-records')->post('/sort-records', 'EmployeesController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'EmployeesController@edit');
            Route::name('update')->put('/{record}', 'EmployeesController@update');
            Route::name('delete')->delete('/{record}', 'EmployeesController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'EmployeesController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'EmployeesController@togglePromotion');
        });

        Route::prefix('general-catalogs')->as('general-catalogs.')->namespace('Catalogs')->group(function(){
            Route::name('index')->get('/', 'CatalogsController@index');
            Route::name('store')->post('/', 'CatalogsController@store');
            Route::name('create')->get('/create', 'CatalogsController@create');
            Route::name('sort')->get('/sort', 'CatalogsController@sort');
            Route::name('sort-records')->post('/sort-records', 'CatalogsController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'CatalogsController@edit');
            Route::name('update')->put('/{record}', 'CatalogsController@update');
            Route::name('delete')->delete('/{record}', 'CatalogsController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'CatalogsController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'CatalogsController@togglePromotion');
        });

        Route::prefix('certificates')->as('certificates.')->namespace('Certificates')->group(function(){
            Route::name('index')->get('/', 'CertificatesController@index');
            Route::name('store')->post('/', 'CertificatesController@store');
            Route::name('create')->get('/create', 'CertificatesController@create');
            Route::name('sort')->get('/sort', 'CertificatesController@sort');
            Route::name('sort-records')->post('/sort-records', 'CertificatesController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'CertificatesController@edit');
            Route::name('update')->put('/{record}', 'CertificatesController@update');
            Route::name('delete')->delete('/{record}', 'CertificatesController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'CertificatesController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'CertificatesController@togglePromotion');
        });

        Route::prefix('job-openings')->as('job-openings.')->namespace('JobOpenings')->group(function(){
            Route::name('index')->get('/', 'JobOpeningsController@index');
            Route::name('store')->post('/', 'JobOpeningsController@store');
            Route::name('create')->get('/create', 'JobOpeningsController@create');
            Route::name('sort')->get('/sort', 'JobOpeningsController@sort');
            Route::name('sort-records')->post('/sort-records', 'JobOpeningsController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'JobOpeningsController@edit');
            Route::name('update')->put('/{record}', 'JobOpeningsController@update');
            Route::name('delete')->delete('/{record}', 'JobOpeningsController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'JobOpeningsController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'JobOpeningsController@togglePromotion');
        });

        Route::prefix('logos')->as('logos.')->namespace('Logos')->group(function(){
            Route::name('index')->get('/', 'LogosController@index');
            Route::name('store')->post('/', 'LogosController@store');
            Route::name('create')->get('/create', 'LogosController@create');
            Route::name('sort')->get('/sort', 'LogosController@sort');
            Route::name('sort-records')->post('/sort-records', 'LogosController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'LogosController@edit');
            Route::name('update')->put('/{record}', 'LogosController@update');
            Route::name('delete')->delete('/{record}', 'LogosController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'LogosController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'LogosController@togglePromotion');
        });

        Route::prefix('main-settings')->as('main-settings.')->namespace('MainSettings')->group(function(){
            Route::name('index')->get('/', 'MainSettingsController@index');
            Route::name('store')->post('/', 'MainSettingsController@store');
            Route::name('create')->get('/create', 'MainSettingsController@create');
            Route::name('sort')->get('/sort', 'MainSettingsController@sort');
            Route::name('sort-records')->post('/sort-records', 'MainSettingsController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'MainSettingsController@edit');
            Route::name('update')->put('/{record}', 'MainSettingsController@update');
            Route::name('delete')->delete('/{record}', 'MainSettingsController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'MainSettingsController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'MainSettingsController@togglePromotion');
        });

        Route::prefix('medias')->as('medias.')->namespace('Medias')->group(function(){
            Route::name('index')->get('/', 'MediasController@index');
            Route::name('store')->post('/', 'MediasController@store');
            Route::name('create')->get('/create', 'MediasController@create');
            Route::name('sort')->get('/sort', 'MediasController@sort');
            Route::name('sort-records')->post('/sort-records', 'MediasController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'MediasController@edit');
            Route::name('update')->put('/{record}', 'MediasController@update');
            Route::name('delete')->delete('/{record}', 'MediasController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'MediasController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'MediasController@togglePromotion');
        });

        Route::prefix('product-catalogs')->as('product-catalogs.')->namespace('ProductCatalogs')->group(function(){
            Route::name('index')->get('/', 'ProductCatalogsController@index');
            Route::name('store')->post('/', 'ProductCatalogsController@store');
            Route::name('create')->get('/create', 'ProductCatalogsController@create');
            Route::name('sort')->get('/sort', 'ProductCatalogsController@sort');
            Route::name('sort-records')->post('/sort-records', 'ProductCatalogsController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'ProductCatalogsController@edit');
            Route::name('update')->put('/{record}', 'ProductCatalogsController@update');
            Route::name('delete')->delete('/{record}', 'ProductCatalogsController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'ProductCatalogsController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'ProductCatalogsController@togglePromotion');
        });

        Route::prefix('product-images')->as('product-images.')->namespace('ProductImages')->group(function(){
            Route::name('index')->get('/', 'ProductImagesController@index');
            Route::name('store')->post('/', 'ProductImagesController@store');
            Route::name('create')->get('/create', 'ProductImagesController@create');
            Route::name('sort')->get('/sort', 'ProductImagesController@sort');
            Route::name('sort-records')->post('/sort-records', 'ProductImagesController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'ProductImagesController@edit');
            Route::name('update')->put('/{record}', 'ProductImagesController@update');
            Route::name('delete')->delete('/{record}', 'ProductImagesController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'ProductImagesController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'ProductImagesController@togglePromotion');
        });

        Route::prefix('references')->as('references.')->namespace('References')->group(function(){
            Route::name('index')->get('/', 'ReferencesController@index');
            Route::name('store')->post('/', 'ReferencesController@store');
            Route::name('create')->get('/create', 'ReferencesController@create');
            Route::name('sort')->get('/sort', 'ReferencesController@sort');
            Route::name('sort-records')->post('/sort-records', 'ReferencesController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'ReferencesController@edit');
            Route::name('update')->put('/{record}', 'ReferencesController@update');
            Route::name('delete')->delete('/{record}', 'ReferencesController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'ReferencesController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'ReferencesController@togglePromotion');
        });

        Route::prefix('testimonials')->as('testimonials.')->namespace('Testimonials')->group(function(){
            Route::name('index')->get('/', 'TestimonialsController@index');
            Route::name('store')->post('/', 'TestimonialsController@store');
            Route::name('create')->get('/create', 'TestimonialsController@create');
            Route::name('sort')->get('/sort', 'TestimonialsController@sort');
            Route::name('sort-records')->post('/sort-records', 'TestimonialsController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'TestimonialsController@edit');
            Route::name('update')->put('/{record}', 'TestimonialsController@update');
            Route::name('delete')->delete('/{record}', 'TestimonialsController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'TestimonialsController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'TestimonialsController@togglePromotion');
        });

        Route::prefix('popups')->as('popups.')->namespace('Popups')->group(function(){
            Route::name('index')->get('/', 'PopupsController@index');
            Route::name('store')->post('/', 'PopupsController@store');
            Route::name('create')->get('/create', 'PopupsController@create');
            Route::name('sort')->get('/sort', 'PopupsController@sort');
            Route::name('sort-records')->post('/sort-records', 'PopupsController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'PopupsController@edit');
            Route::name('update')->put('/{record}', 'PopupsController@update');
            Route::name('delete')->delete('/{record}', 'PopupsController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'PopupsController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'PopupsController@togglePromotion');
        });

        Route::prefix('video')->as('video.')->namespace('Video')->group(function(){
            Route::name('index')->get('/', 'VideosController@index');
           
            Route::name('edit')->get('/{record}/edit', 'VideosController@edit');
            Route::name('update')->put('/{record}', 'VideosController@update');
           
        });

        Route::prefix('tests')->as('tests.')->namespace('Tests')->group(function(){
            Route::name('index')->get('/', 'TestsController@index');
            Route::name('store')->post('/', 'TestsController@store');
            Route::name('create')->get('/create', 'TestsController@create');
            Route::name('sort')->get('/sort', 'TestsController@sort');
            Route::name('sort-records')->post('/sort-records', 'TestsController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'TestsController@edit');
            Route::name('update')->put('/{record}', 'TestsController@update');
            Route::name('delete')->delete('/{record}', 'TestsController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'TestsController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'TestsController@togglePromotion');
        });

        Route::prefix('fields')->as('fields.')->namespace('Fields')->group(function(){
            Route::name('index')->get('/', 'FieldsController@index');
            Route::name('store')->post('/', 'FieldsController@store');
            Route::name('create')->get('/create', 'FieldsController@create');
            Route::name('sort')->get('/sort', 'FieldsController@sort');
            Route::name('sort-records')->post('/sort-records', 'FieldsController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'FieldsController@edit');
            Route::name('update')->put('/{record}', 'FieldsController@update');
            Route::name('delete')->delete('/{record}', 'FieldsController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'FieldsController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'FieldsController@togglePromotion');
        });

        Route::prefix('products')->as('products.')->namespace('Products')->group(function(){
            Route::name('index')->get('/', 'ProductsController@index');
            Route::name('store')->post('/', 'ProductsController@store');
            Route::name('create')->get('/create', 'ProductsController@create');
            Route::name('sort')->get('/sort', 'ProductsController@sort');
            Route::name('sort-records')->post('/sort-records', 'ProductsController@sortRecords');
            Route::name('edit')->get('/{record}/edit', 'ProductsController@edit');
            Route::name('update')->put('/{record}', 'ProductsController@update');
            Route::name('delete')->delete('/{record}', 'ProductsController@delete');
            Route::name('delete-file')->delete('/{record}/delete-file', 'ProductsController@deleteFile');
            Route::name('toggle-promotion')->post('/toggle-promotion', 'ProductsController@togglePromotion');
        });
    });
});