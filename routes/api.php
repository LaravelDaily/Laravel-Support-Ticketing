<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Statuses
    Route::apiResource('statuses', 'StatusesApiController');

    // Priorities
    Route::apiResource('priorities', 'PrioritiesApiController');

    // Categories
    Route::apiResource('categories', 'CategoriesApiController');

    // Tickets
    Route::post('tickets/media', 'TicketsApiController@storeMedia')->name('tickets.storeMedia');
    Route::apiResource('tickets', 'TicketsApiController');

    // Comments
    Route::apiResource('comments', 'CommentsApiController');
});
