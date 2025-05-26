<?php

return [
    [
        'name' => 'Dashboard',
        'icon' => 'nav-icon bi bi-speedometer',
        'route' => 'dashboard.home',
        'active' => 'dashboard.home'
    ],
    [
        'name' => 'Categories',
        'icon' => 'nav-icon bi bi-speedometer',
        'route' => 'dashboard.categories.index',
        'active' => 'dashboard.categories.*'
    ],
];
