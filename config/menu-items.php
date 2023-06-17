<?php

return [
    [
        'title' => 'Dashboard',
        'type'  => 'item',
        'route' => 'dashboard',
        'icon'  => 'tachometer-alt',
        'roles' => 'admin',
    ],
    [
        'title' => 'Clients',
        'type'  => 'item',
        'route' => 'customers.index',
        'icon'  => 'users',
        'roles' => 'admin',
    ],
    [
        'title' => 'Transporteurs',
        'type'  => 'item',
        'route' => 'transporters.index',
        'icon'  => 'truck-front',
        'roles' => 'admin',
    ],
    [
        'title' => 'Ajouter un dossier',
        'type'  => 'item',
        'route' => 'folders.create',
        'icon'  => 'folder-plus',
        'roles' => 'customer',
    ],
    [
        'title' => 'Dossiers',
        'type'  => 'item',
        'route' => 'folders.index',
        'icon'  => 'folder',
        'roles' => 'admin|customer',
    ],
    [
        'title' => 'Dossiers en attentes',
        'type'  => 'item',
        'route' => 'pending-folders.index',
        'icon'  => 'folder-plus',
        'roles' => 'admin|customer',
    ],
    [
        'title' => 'Dossiers en cours',
        'type'  => 'item',
        'route' => 'progress-folders.index',
        'icon'  => 'folder-open',
        'roles' => 'admin|customer',
    ],
    [
        'title' => 'Dossiers fermés',
        'type'  => 'item',
        'route' => 'closed-folders.index',
        'icon'  => 'folder-closed',
        'roles' => 'admin|customer',
    ],
    // [
    //     'title' => 'Utilisateurs',
    //     'type'  => 'item',
    //     'route' => 'users.index',
    //     'icon'  => 'user',
    //     'roles' => 'admin',
    // ],
];
