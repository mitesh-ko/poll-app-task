<?php
$providers = 
[
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    App\Providers\FortifyServiceProvider::class,
    App\Providers\AppBindingProvider::class,
];

if (app()->environment('local')) {
    $providers[] = App\Providers\TelescopeServiceProvider::class;
}

return $providers;
