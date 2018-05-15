<?php

namespace Emtudo\Domains\Jobs\Providers;

use Emtudo\Domains\Jobs\Database\Migrations;
use Emtudo\Support\Domain\ServiceProvider;

/**
 * Class DomainServiceProvider.
 */
class DomainServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    public $alias = 'jobs';

    protected $migrations = [
        Migrations\CreateJobsTable::class,
        Migrations\CreateFailedJobsTable::class,
    ];
}
