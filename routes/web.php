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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

	Route::get('/', 'HomeController@index')->name('dashboard');
	
	Route::group(['as' => 'user:'], function() {
	
/*
		// user profile & settings
		Route::get('/profile', 'UserController@edit')->name('edit');	
		Route::put('/profile/edit', 'UserController@update')->name('edit:save');
		Route::get('/profile/pass', 'UserController@password')->name('pass');
		Route::put('/profile/pass', 'UserController@passwordSave')->name('pass:save');
*/
		
		// add away days
		Route::post('/calendar/away/add', 'CalendarController@store')->name('away:add');		
		Route::delete('/calendar/away/del/{id}', 'CalendarController@destroy')->name('away:delete');
		
	});
	
	Route::get('/calendar/{start?}/{length?}/{move?}', 'CalendarController@index')->name('calendar');
		
});

Route::group(['middleware' => ['team']], function () {
	
	Route::namespace('Team')->group(function() {
		
		// Admin settings
		Route::group(['as' => 'admin:'], function() {
			
			Route::get('/planner', 'CalendarTeamController@index')->name('dashboard');
			
			// users (includes view of IDCards, referrals)
			Route::get('/admin/users', 'UsersTeamController@index')->name('users:list');
			Route::get('/admin/users/new/', 'UsersTeamController@create')->name('users:new');
			Route::post('/admin/users/new', 'UsersTeamController@store')->name('users:create');	
			Route::get('/admin/user/stats/{id}', 'UsersTeamController@show')->name('user:stats');						
			Route::get('/admin/user/edit/{id}', 'UsersTeamController@edit')->name('user:edit');
			Route::put('/admin/user/edit/{id}', 'UsersTeamController@update')->name('user:edit');
			Route::get('/admin/user/del/{id}', 'UsersTeamController@delete')->name('user:del');
			Route::get('/admin/user/del/{id}', 'UsersTeamController@destroy')->name('user:del');
			
			// clients
			Route::get('/admin/clients', 'ClientsTeamController@index')->name('clients:list');			
			Route::get('/admin/clients/new', 'ClientsTeamController@create')->name('clients:new');
			Route::post('/admin/clients/new', 'ClientsTeamController@store')->name('clients:create');
			Route::get('/admin/clients/edit/{id}', 'ClientsTeamController@edit')->name('client:edit');
			Route::put('/admin/clients/edit/{id}', 'ClientsTeamController@update')->name('client:edit');
			Route::get('/admin/clients/del/{id}', 'ClientsTeamController@delete')->name('client:del');
			Route::delete('/admin/clients/del/{id}', 'ClientsTeamController@destroy')->name('client:del');

			// projects
			Route::get('/admin/projects', 'ProjectsTeamController@index')->name('projects:list');			
			Route::get('/admin/projects/new', 'ProjectsTeamController@create')->name('projects:new');
			Route::post('/admin/projects/new', 'ProjectsTeamController@store')->name('projects:create');
			Route::get('/admin/projects/stats/{id}', 'ProjectsTeamController@show')->name('projects:stats');
			Route::get('/admin/projects/edit/{id}', 'ProjectsTeamController@edit')->name('project:edit');
			Route::put('/admin/projects/edit/{id}', 'ProjectsTeamController@update')->name('project:edit');
			Route::get('/admin/projects/del/{id}', 'ProjectsTeamController@delete')->name('project:del');
			Route::delete('/admin/projects/del/{id}', 'ProjectsTeamController@destroy')->name('project:del');

									
			//ajax
			Route::group(['as' => 'ajax:'], function() {
				// clients
				Route::get('/admin/ajax/clients/search', 'ClientsTeamController@ajaxGetByName')->name('clients:search');
				// calendar		
				Route::post('/admin/ajax/calendar/new', 'CalendarTeamController@store')->name('calendar:create');
				Route::put('/admin/ajax/calendar/edit/{id}', 'CalendarTeamController@update')->name('calendar:edit');
				Route::delete('/admin/ajax/calendar/del/{id}', 'CalendarTeamController@destroy')->name('calendar:del');	
			});
		});

	});

});