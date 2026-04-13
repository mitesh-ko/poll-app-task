<?php
$providers = 
[
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    App\Providers\FortifyServiceProvider::class,
];

if (app()->environment('local')) {
    $providers[] = App\Providers\TelescopeServiceProvider::class;
}

return $providers;
