<?php
    
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->post('auth/login',        'App\Api\V1\Controllers\AuthController@login');
    $api->post('auth/signup',       'App\Api\V1\Controllers\AuthController@signup');
    $api->post('auth/recovery',     'App\Api\V1\Controllers\AuthController@recovery');
    $api->post('auth/reset',        'App\Api\V1\Controllers\AuthController@reset');

    $api->group( ['middleware' => ['api.auth', 'cors'] ], function ($api) {
        $api->resource('collectors',    'App\Api\V1\Controllers\CollectorController',
        	['except' => ['show'] ]);

        
    });

    $api->get('grantuserpermission',        'App\Api\V1\Controllers\PermissionController@grantUserPermission');
    $api->get('grantgrouppermission',        'App\Api\V1\Controllers\PermissionController@grantGroupPermission');
    $api->post('createpermission',        'App\Api\V1\Controllers\PermissionController@createPermission');
    $api->get('isallow/{resource}',        'App\Api\V1\Controllers\PermissionController@isAllow');

});
