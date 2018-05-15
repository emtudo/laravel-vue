<?php

namespace Emtudo\Domains\Audits\Providers;

use Emtudo\Domains\Audits\Database\Migrations;
use Emtudo\Support\Domain\ServiceProvider;

/**
 * Class DomainServiceProvider.
 */
class DomainServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    public $alias = 'audits';

    protected $migrations = [
        Migrations\CreateAuditsTable::class,
    ];
}
