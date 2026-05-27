<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Paksa HTTPS di Production/VPS agar tidak terjadi Mixed Content
        if (config('app.env') === 'production') {
            URL::forceRootUrl(config('app.url'));
            URL::forceScheme('https');
        }

        // Implicitly grant "Superadmin" role all permissions
        Gate::before(function ($user, $ability) {
            return $user->hasRole(['Superadmin', 'superadmin']) ? true : null;
        });

        // Share settings globally to all views
        View::composer('*', function ($view) {
            try {
                if (Schema::hasTable('settings')) {
                    $appSettings = \App\Models\Setting::allCached();
                    $view->with('appSettings', $appSettings);
                }
            } catch (\Exception $e) {
                $view->with('appSettings', []);
            }
        });

        // Notifications View Composer
        View::composer('backend.layout.navbar', function ($view) {
            $activities = collect();

            try {
                if (Schema::hasTable('subscriptions')) {
                    $subs = \App\Models\Subscription::with('user')->latest()->take(5)->get()->map(function ($s) {
                        $name = $s->user?->name ?? 'User';
                        return [
                            'message' => "{$name} joined a plan",
                            'time' => $s->created_at,
                            'icon' => 'ki-user-tick text-primary'
                        ];
                    });
                    $activities = $activities->concat($subs);
                }

                if (Schema::hasTable('published_photos')) {
                    $photos = \App\Models\PublishedPhoto::with('user')->latest()->take(5)->get()->map(function ($p) {
                        $name = $p->user ? $p->user->name : 'Guest';
                        return [
                            'message' => "{$name} published a moment",
                            'time' => $p->created_at,
                            'icon' => 'ki-picture text-success'
                        ];
                    });
                    $activities = $activities->concat($photos);
                }

                if (Schema::hasTable('custom_frames')) {
                    $frames = \App\Models\CustomFrame::with('user')->latest()->take(5)->get()->map(function ($f) {
                        $name = $f->user?->name ?? 'User';
                        $action = $f->is_public ? 'published' : 'created';
                        $color = $f->is_public ? 'info' : 'warning';
                        return [
                            'message' => "{$name} {$action} a frame",
                            'time' => $f->created_at,
                            'icon' => "ki-design-frame text-{$color}"
                        ];
                    });
                    $activities = $activities->concat($frames);
                }
                
                // Sort by time descending and take top 5
                $recentActivities = $activities->sortByDesc('time')->take(5)->values();
            } catch (\Exception $e) {
                $recentActivities = collect();
            }

            $view->with('recentActivities', $recentActivities);
        });
    }
}
