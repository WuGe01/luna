<?php

/**
 * Part of earth project.
 *
 * @copyright  Copyright (C) 2021 __ORGANIZATION__.
 * @license    __LICENSE__
 */

declare(strict_types=1);

use Lyrasoft\Luna\LunaPackage;
use Lyrasoft\Luna\Subscriber\BuildFormFieldSubscriber;
use Lyrasoft\Luna\Subscriber\EntityBuildingSubscriber;
use Lyrasoft\Luna\Subscriber\LocaleSubscriber;
use Lyrasoft\Luna\User\Handler\SessionDatabaseHandler;
use Windwalker\Core\Application\AppContext;
use Windwalker\Session\Handler\DatabaseHandler;

return [
    'luna' => [
        'enabled' => true,

        'providers' => [
            LunaPackage::class
        ],

        'listeners' => [
            EntityBuildingSubscriber::class,
            BuildFormFieldSubscriber::class,
            AppContext::class => [
                LocaleSubscriber::class
            ]
        ],

        'aliases' => [
            DatabaseHandler::class => SessionDatabaseHandler::class
        ],

        'view_extends' => [
            'front' => [
                'base' => 'global.body',
                'auth' => 'global.auth',
                'error' => 'global.body',
            ],

            'admin' => [
                'base' => 'admin.global.body',
                'auth' => 'admin.global.auth',
                'edit' => 'admin.global.body-edit',
                'list' => 'admin.global.body-list',
                'modal' => 'admin.global.pure',
                'error' => 'admin.global.pure',
            ]
        ],

        'i18n' => [
            'enabled' => false,
            'uri_prefix' => true,
        ],

        'error' => [
            'route' => 'front::home',
            'layout' => null
        ]
    ]
];
