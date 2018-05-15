<?php

namespace Emtudo\Domains\Users\Providers;

use Emtudo\Domains\Users\Contracts;
use Emtudo\Domains\Users\Database\Factories;
use Emtudo\Domains\Users\Database\Migrations;
use Emtudo\Domains\Users\Database\Seeders;
use Emtudo\Domains\Users\Repositories;
use Emtudo\Support\Domain\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    public $bindings = [
        Contracts\UserRepository::class => Repositories\UserRepository::class,
    ];
    /**
     * @var string
     */
    protected $alias = 'users';

    protected $migrations = [
        Migrations\CreateUsersTable::class,
        Migrations\CreatePasswordResetsTable::class,
    ];

    protected $seeders = [
        Seeders\UserSeeder::class,
    ];

    protected $factories = [
        Factories\UserFactory::class,
    ];
}
