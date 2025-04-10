<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\{
    Project,
    User
};
use App\Observers\{
    ProjectObserver,
    UserObserver
};
use Guava\FilamentKnowledgeBase\Filament\Panels\KnowledgeBasePanel;
use Illuminate\Support\Facades\Vite;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        KnowledgeBasePanel::configureUsing(
            fn(KnowledgeBasePanel $panel) => $panel
                ->viteTheme('resources/css/themes/knowledge-base.css')
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Project::observe(ProjectObserver::class);
        User::observe(UserObserver::class);
    }
}
