<?php

namespace Reddot\TegetaReservation;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasRoute('web')
            ->hasViews();
    }

    public function bootingPackage() : void
    {
        $this->app->bind('tegeta-reservation-service', function () {
            return new ReservationService();
        });
    }
}
