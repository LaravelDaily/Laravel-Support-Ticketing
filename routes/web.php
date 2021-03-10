<?php

Route::get('/telegram', 'TelegramNotificationController@toTelegram');

Route::get('/', 'TicketController@create');
Route::get('/allticket', 'TicketController@index');
Route::get('/home', function () {
    $route = Gate::denies('dashboard_access') ? 'admin.tickets.index' : 'admin.home';
    if (session('status')) {
        return redirect()->route($route)->with('status', session('status'));
    }

    return redirect()->route($route);
});

Auth::routes(['register' => false]);

Route::post('tickets/media', 'TicketController@storeMedia')->name('tickets.storeMedia');
Route::post('tickets/comment/{ticket}', 'TicketController@storeComment')->name('tickets.storeComment');
Route::resource('tickets', 'TicketController')->only(['show', 'create', 'store']);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Statuses
    Route::delete('statuses/destroy', 'StatusesController@massDestroy')->name('statuses.massDestroy');
    Route::resource('statuses', 'StatusesController');

    // Priorities
    Route::delete('priorities/destroy', 'PrioritiesController@massDestroy')->name('priorities.massDestroy');
    Route::resource('priorities', 'PrioritiesController');

    // Categories
    Route::delete('categories/destroy', 'CategoriesController@massDestroy')->name('categories.massDestroy');
    Route::resource('categories', 'CategoriesController');

    // Tickets
    Route::delete('tickets/destroy', 'TicketsController@massDestroy')->name('tickets.massDestroy');
    Route::post('tickets/media', 'TicketsController@storeMedia')->name('tickets.storeMedia');
    Route::post('tickets/comment/{ticket}', 'TicketsController@storeComment')->name('tickets.storeComment');
    Route::resource('tickets', 'TicketsController');

    // Comments
    Route::delete('comments/destroy', 'CommentsController@massDestroy')->name('comments.massDestroy');
    Route::resource('comments', 'CommentsController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Peminjaman 
    //upload peminjaman
    Route::post('peminjaman/upload', 'PeminjamanController@upload')->name('peminjaman.upload');
    //mass destroy
    Route::delete('peminjaman/destroy', 'PeminjamanController@massDestroy')->name('peminjaman.massDestroy');
    //range report laporan peminjaman
    Route::get('peminjaman/rangeReport', 'PeminjamanController@rangeReport')->name('peminjaman.rangeReport');
    //peminjaman pengembalian
    Route::get('peminjaman/{id}/pengembalian', 'PeminjamanController@pengembalian')->name('peminjaman.pengembalian');
    //updatePengembalian
    Route::put('peminjaman/{id}/pengembalian', 'PeminjamanController@pengembalianUpdate')->name('peminjaman.updatePengembalian');
    Route::resource('peminjaman', 'PeminjamanController');

    // Kunci
    Route::resource('kunci', 'KunciController');
});
