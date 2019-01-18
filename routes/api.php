<?php

use Illuminate\Http\Request;

Route::namespace('Api')->group(function () {
    Route::namespace('Internal')->prefix('internal')->group(function () {
        Route::namespace('Admin')->prefix('admin')->group(function () {
            Route::get('dashboard', 'DashboardController@index');

        });
        Route::post('media/upload', 'MediaController@upload');
        Route::prefix(config('media-manager.routes.prefix'))->group(function() {
            Route::get('browser/index', 'MediaManagerController@ls');

            Route::post('browser/file', 'MediaManagerController@uploadFiles');
            Route::delete('browser/file', 'MediaManagerController@deleteFile');
            Route::post('browser/folder', 'MediaManagerController@createFolder');
            Route::delete('browser/folder', 'MediaManagerController@deleteFolder');

            Route::post('browser/rename', 'MediaManagerController@rename');
            Route::get('browser/directories', 'MediaManagerController@allDirectories');
            Route::post('browser/move', 'MediaManagerController@move');
        });
//        Route::post('change-password', 'ChangePasswordController@changePassword')->name('auth.change_password');

    });
});
