<?php

return [
    [
        'title' => 'Dashboard',
        'type'  => 'item',
        'route' => 'dashboard',
        'icon'  => 'tachometer-alt',
        'roles' => 'Admin',
    ],
    [
        'title' => 'Clients',
        'type'  => 'item',
        'route' => 'customers.index',
        'icon'  => 'users',
        'roles' => 'Admin',
    ],
    [
        'title' => 'Transporteurs',
        'type'  => 'item',
        'route' => 'transporters.index',
        'icon'  => 'truck-front',
        'roles' => 'Admin',
    ],
    [
        'title' => 'Ajouter un dossier',
        'type'  => 'item',
        'route' => 'folders.create',
        'icon'  => 'folder-plus',
        'roles' => 'Admin|Customer',
    ],
    [
        'title' => 'Dossiers',
        'type'  => 'item',
        'route' => 'folders.index',
        'icon'  => 'folder',
        'roles' => 'Admin|Customer',
    ],
    [
        'title' => 'Dossiers en attentes',
        'type'  => 'item',
        'route' => 'pending-folders.index',
        'icon'  => 'folder-plus',
        'roles' => 'Admin|Customer',
    ],
    [
        'title' => 'Dossiers en cours',
        'type'  => 'item',
        'route' => 'progress-folders.index',
        'icon'  => 'folder-open',
        'roles' => 'Admin|Customer',
    ],
    [
        'title' => 'Dossiers fermés',
        'type'  => 'item',
        'route' => 'closed-folders.index',
        'icon'  => 'folder-closed',
        'roles' => 'Admin|Customer',
    ],
    // [
    //     'title' => 'Utilisateurs',
    //     'type'  => 'item',
    //     'route' => 'users.index',
    //     'icon'  => 'user',
    //     'roles' => 'Admin',
    // ],
];
