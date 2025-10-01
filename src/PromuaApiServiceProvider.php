<?php
 
namespace Dvomaks\PromuaApi;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PromuaApiServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('promua-api')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_promua_api_table');
    }
}
