<?php

return [
    [
        'name' => 'Dashboard',
        'role' => '',
        'img' => 'assets/image/icons/bar-chart.png',
        'link' => 'DashboardController@index'
    ],
    ['name' => 'Links', 'role' => '', 'img' => 'assets/image/icons/receipt.png', 'link' => 'LinksController@index'], // คลักหลัก
    ['name' => 'Analytics', 'role' => '', 'img' => 'assets/image/icons/receipt.png', 'link' => 'AnalyticsController@index'], // คลักหลัก
    [
        'name' => 'ระบบเจ้าหน้าที่',
        'role' => 'admin',
        'img' => 'assets/image/icons/setting.png',
        'module' => [
            ['name' => 'Links All', 'role' => 'admin', 'icon' => '', 'link' => 'Admin\LinksController@index'],
            ['name' => 'ผู้ใช้งาน', 'role' => 'admin', 'icon' => '', 'link' => 'Admin\UserController@index'],
        ],
    ],

];
