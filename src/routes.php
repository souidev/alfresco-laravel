<?php

Route::group(['prefix' => 'souidev/alfresco','middleware' => ['web','auth','language']	], function () {



	Route::get('download/{id}', 'Souidev\AlfrescoLaravel\Controllers\AlfrescoLaravelController@download')->name("alfresco.download");

	Route::get('view/{id}', 'Souidev\AlfrescoLaravel\Controllers\AlfrescoLaravelController@viewDocument')->name("alfresco.view");

	Route::get('preview/{id}', 'Souidev\AlfrescoLaravel\Controllers\AlfrescoLaravelController@previewDocument')->name("alfresco.preview");


	Route::delete('delete/{id}', 'Souidev\AlfrescoLaravel\Controllers\AlfrescoLaravelController@delete')->name("alfresco.delete");


	Route::get('info/{id}', 'Souidev\AlfrescoLaravel\Controllers\AlfrescoLaravelController@info')->name("alfresco.info");

	Route::get('add/{id}', 'Souidev\AlfrescoLaravel\Controllers\AlfrescoLaravelController@addmodal')->name("alfresco.addmodal");

	Route::post('add/{id}', 'Souidev\AlfrescoLaravel\Controllers\AlfrescoLaravelController@add')->name("alfresco.add");

	Route::get('createfolder/{id}', 'Souidev\AlfrescoLaravel\Controllers\AlfrescoLaravelController@createfoldermodal')->name("alfresco.createfoldermodal");

	Route::post('createfolder/{id}', 'Souidev\AlfrescoLaravel\Controllers\AlfrescoLaravelController@createfolder')->name("alfresco.createfolder");


	Route::get('rename/{id}', 'Souidev\AlfrescoLaravel\Controllers\AlfrescoLaravelController@renamemodal')->name("alfresco.renamemodal");

	Route::post('rename/{id}', 'Souidev\AlfrescoLaravel\Controllers\AlfrescoLaravelController@rename')->name("alfresco.rename");


	Route::post('search/{id}', 'Souidev\AlfrescoLaravel\Controllers\AlfrescoLaravelController@search')->name("alfresco.search");

	Route::get('searchresults', 'Souidev\AlfrescoLaravel\Controllers\AlfrescoLaravelController@searchresults')->name("alfresco.searchresults");

	Route::post('batch/{id}', 'Souidev\AlfrescoLaravel\Controllers\AlfrescoLaravelController@batch')->name("alfresco.batch");

	Route::post('copy/{id}', 'Souidev\AlfrescoLaravel\Controllers\AlfrescoLaravelController@copymodal')->name("alfresco.copymodal");

	Route::post('move/{id}', 'Souidev\AlfrescoLaravel\Controllers\AlfrescoLaravelController@movemodal')->name("alfresco.movemodal");


	Route::get('tree/{id}', 'Souidev\AlfrescoLaravel\Controllers\AlfrescoLaravelController@tree')->name("alfresco.tree");



});

Route::group(['prefix' => 'souidev/alfresco','middleware' => ['alfresco-explorer','web','auth','language']	], function () {

		Route::get('/explorer/{folder?}', 'Souidev\AlfrescoLaravel\Controllers\AlfrescoLaravelController@explorer')->name("alfresco.explorer")->where('folder', '(.*)');
});
