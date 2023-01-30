<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Opcodes\LogViewer\Log;
use Opcodes\LogViewer\LogFile;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('viewLogViewer', function (?User $user) {
            return true;
            // return true if the user is allowed access to the Log Viewer
            //
        });

        Gate::define('downloadLogFile', function (?User $user, LogFile $file) {
            foreach ($file as $item) {
                \Illuminate\Support\Facades\Log::info(json_encode($item));
            }
            return true;
            // return true if the user is allowed to download the specific log file.
        });
    }
}
