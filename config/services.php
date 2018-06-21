<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'google' => [
        'client_id' => '',
      //  'client_id' => '8838069962-7bbjcufeealqbn3g7vra586i61ihss71.apps.googleusercontent.com',
        'client_secret' => '-EbxnomDsxXBsnrtcNDrJcPu',
        'redirect' => 'http://ultimate.sximo5.net/user/autosocialize/google',
    ],

    'twitter' => [
        'client_id' => '',
     //   'client_id' => 'q2NR24fPB2VtayTOMa6NDAG9s',
        'client_secret' => 'deLBI0nVkllV1aAOrohk0X9nDJY1tognRQO2myJsGis9GnmBCY',
        'redirect' => 'http://ultimate.sximo5.net/user/autosocialize/twitter',
    ],

    'facebook' => [
        'client_id' => '',
     //   'client_id' => '950e212d7db159cc669cf1790fcc9d94',
        'client_secret' => 'e865693fbf58750bc81d3595acfeb3bc',
        'redirect' => 'http://ultimate.sximo5.net/user/autosocialize/facebook',
    ],  
];
