<?php

namespace Reddot\TegetaReservation;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Reddot\TegetaReservation\Commands\TegetaReservationCommand;

class TegetaReservationServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('tegeta-reservation')
            ->hasConfigFile()
            ->hasViews();
    }
}
