<?php

    return [

        'host' => env('MAIL_HOST', "smtp.example.com"),

        'auth' => env('SMTP_AUTH', 587),

        'username' => env('MAIL_USERNAME', ""),

        'password' => env('MAIL_PASSWORD', ""),

        'port' => env('MAIL_PORT', 587),

        'from' => env('MAIL_FROM', "no-reply@example.com"),

    ];
