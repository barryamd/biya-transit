<?php

/*
 * For more details about the configuration, see:
 * https://sweetalert2.github.io/#configuration
 */
return [
    'alert' => [
        'toast' => true,
        'text' => null,
        'position' => 'top-end',
        'showConfirmButton' => false,
        'showCancelButton' => false,
        'timer' => 8000,
        'timerProgressBar' => true,
        /*'didOpen' => (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer),
            toast.addEventListener('mouseleave', Swal.resumeTimer
        }*/
    ],
    'confirm' => [
        'icon' => 'warning',
        'position' => 'center',
        'toast' => false,
        'timer' => null,
        'showConfirmButton' => true,
        'showCancelButton' => true,
        'cancelButtonText' => 'No',
        'confirmButtonColor' => '#d33',
        'cancelButtonColor' => '#3085d6',
    ]
];
