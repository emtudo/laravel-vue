<?php

namespace Emtudo\Support\Domain;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Migrator\MigratorTrait as HasMigrations;
use ReflectionClass;

/**
 * Abstract ServiceProvider for Domains.
 */
abstract class ServiceProvider extends LaravelServiceProvider
{
    // Enable migrations trait
    use HasMigrations;

    /**
     * @var array Contract bindings
     */
    public $bindings = [];

    /**
     * @var string Domain alias for resources
     */
    protected $alias;

    /**
     * @var array List of domain providers to register
     */
    protected $subProviders;

    /**
     * @var array List of migrations provided by Domain
     */
    protected $migrations = [];

    /**
     * @var array List of seeders provided by Domain
     */
    protected $seeders = [];

    /**
     * @var array List of model factories to load
     */
    protected $factories = [];

    /**
     * Register the current Domain.
     */
    public function register()
    {
        // Register Sub Providers
        $this->registerSubProviders(collect($this->subProviders));

        // Register bindings.
        $this->registerBindings(collect($this->bindings));

        // Register migrations.
        $this->registerMigrations(collect($this->migrations));

        // Register seeders.
        $this->registerSeeders(collect($this->seeders));

        // Register model factories.
        $this->registerFactories(collect($this->factories));
    }

    /**
     * Register domain sub providers.
     *
     * @param \Illuminate\Support\Collection $subProviders
     */
    protected function registerSubProviders(Collection $subProviders)
    {
        $subProviders->each(function ($provider) {
            $this->app->register($provider);
        });
    }

    /**
     * Register the defined domain bindings.
     *
     * @param \Illuminate\Support\Collection $bindings
     */
    protected function registerBindings(Collection $bindings)
    {
        $bindings->each(function ($concretion, $abstraction) {
            $this->app->bind($abstraction, $concretion);
        });
    }

    /**
     * Register the defined migrations.
     *
     * @param \Illuminate\Support\Collection $migrations
     */
    protected function registerMigrations(Collection $migrations)
    {
        $this->migrations($migrations->all());
    }

    /**
     * Register the defined seeders.
     *
     * @param \Illuminate\Support\Collection $seeders
     */
    protected function registerSeeders(Collection $seeders)
    {
        $this->seeders($seeders->all());
    }

    /**
     * Register Model Factories.
     *
     * @param \Illuminate\Support\Collection $factories
     */
    protected function registerFactories(Collection $factories)
    {
        $factories->each(function ($factoryName) {
            (new $factoryName())->define();
        });
    }

    /**
     * @param string $append
     *
     * @return string
     */
    protected function domainPath($append = null)
    {
        $reflection = new ReflectionClass($this);
        $realPath = realpath(dirname($reflection->getFileName()).'/../');
        if (!$append) {
            return $realPath;
        }

        return $realPath.'/'.$append;
    }
}
