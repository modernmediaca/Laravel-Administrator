<?php

/**
 * Routes
 */
$router->group(array('prefix' => Config::get('administrator::administrator.uri'), 'before' => 'validate_admin'), function($router)
{
	//Admin Dashboard
	$router->get('/', array(
		'as' => 'admin_dashboard',
		'uses' => 'AdminController@dashboard',
	));

	//File Downloads
	$router->get('file_download', array(
		'as' => 'admin_file_download',
		'uses' => 'AdminController@fileDownload'
	));

	//Custom Pages
	$router->get('page/{page}', array(
		'as' => 'admin_page',
		'uses' => 'AdminController@page'
	));

	$router->group(array('before' => 'validate_settings|post_validate'), function($router)
	{
		//Settings Pages
		$router->get('settings/{settings}', array(
			'as' => 'admin_settings',
			'uses' => 'AdminController@settings'
		));

		//Display a settings file
		$router->get('settings/{settings}/file', array(
			'as' => 'admin_settings_display_file',
			'uses' => 'AdminController@displayFile'
		));

		//CSRF routes
		$router->group(array('before' => 'csrf'), function($router)
		{
			//Save Item
			$router->post('settings/{settings}/save', array(
				'as' => 'admin_settings_save',
				'uses' => 'AdminController@settingsSave'
			));

			//Custom Action
			$router->post('settings/{settings}/custom_action', array(
				'as' => 'admin_settings_custom_action',
				'uses' => 'AdminController@settingsCustomAction'
			));
		});
        
		//Settings file upload
		$router->post('settings/{settings}/{field}/file_upload', array(
			'as' => 'admin_settings_file_upload',
			'uses' => 'AdminController@fileUpload'
		));
	});

	//Switch locales
	$router->get('switch_locale/{locale}', array(
		'as' => 'admin_switch_locale',
		'uses' => 'AdminController@switchLocale'
	));

	//The route group for all other requests needs to validate admin, model, and add assets
	$router->group(array('before' => 'validate_model|post_validate'), function($router)
	{
		//Model Index
		$router->get('{model}', array(
			'as' => 'admin_index',
			'uses' => 'AdminController@index'
		));

		//New Item
		$router->get('{model}/new', array(
			'as' => 'admin_new_item',
			'uses' => 'AdminController@item'
		));

		//Update a relationship's items with constraints
		$router->post('{model}/update_options', array(
			'as' => 'admin_update_options',
			'uses' => 'AdminController@updateOptions'
		));

		//Display an image or file field's image or file
		$router->get('{model}/file', array(
			'as' => 'admin_display_file',
			'uses' => 'AdminController@displayFile'
		));

		//Updating Rows Per Page
		$router->post('{model}/rows_per_page', array(
			'as' => 'admin_rows_per_page',
			'uses' => 'AdminController@rowsPerPage'
		));

		//Get results
		$router->post('{model}/results', array(
			'as' => 'admin_get_results',
			'uses' => 'AdminController@results'
		));

		//Custom Model Action
		$router->post('{model}/custom_action', array(
			'as' => 'admin_custom_model_action',
			'uses' => 'AdminController@customModelAction'
		));

		//Get Item
		$router->get('{model}/{id}', array(
			'as' => 'admin_get_item',
			'uses' => 'AdminController@item'
		));

		//File Uploads
		$router->post('{model}/{field}/file_upload', array(
			'as' => 'admin_file_upload',
			'uses' => 'AdminController@fileUpload'
		));

		//CSRF protection in forms
		$router->group(array('before' => 'csrf'), function($router)
		{
			//Save Item
			$router->post('{model}/{id?}/save', array(
				'as' => 'admin_save_item',
				'uses' => 'AdminController@save'
			));

			//Delete Item
			$router->post('{model}/{id}/delete', array(
				'as' => 'admin_delete_item',
				'uses' => 'AdminController@delete'
			));

			//Custom Item Action
			$router->post('{model}/{id}/custom_action', array(
				'as' => 'admin_custom_model_item_action',
				'uses' => 'AdminController@customModelItemAction'
			));
		});
	});
});
