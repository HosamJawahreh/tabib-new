<?php

namespace App\Providers;

use App\Models\Currency;
use App\Models\Language;
use Illuminate\{
    Support\Facades\DB,
    Support\Collection,
    Support\ServiceProvider,
    Pagination\LengthAwarePaginator
};

use App\Models\Font;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Paginator::useBootstrap();

        // Check if installation is complete before accessing database
        if (!file_exists(base_path('rooted.txt'))) {
            return;
        }

        // Skip view composers if we can't connect to database
        try {
            DB::getPdo();
        } catch (\Exception $e) {
            return;
        }

        view()->composer('*', function ($settings) {

            $settings->with('gs', cache()->remember('generalsettings', now()->addDay(), function () {
                return DB::table('generalsettings')->first();
            }));

            $settings->with('ps', cache()->remember('pagesettings', now()->addDay(), function () {
                return DB::table('pagesettings')->first();
            }));

            $settings->with('seo', cache()->remember('seotools', now()->addDay(), function () {
                return DB::table('seotools')->first();
            }));
            $settings->with('socialsetting', cache()->remember('socialsettings', now()->addDay(), function () {
                return DB::table('socialsettings')->first();
            }));

            $settings->with('default_font', cache()->remember('default_font', now()->addDay(), function () {
                return Font::whereIsDefault(1)->first();
            }));

            if (Session::has('currency')) {
                $settings->with('curr', Currency::find(Session::get('currency')));
            } else {
                $settings->with('curr', Currency::where('is_default', '=', 1)->first());
            }

            if (Session::has('language')) {
                $settings->with('langg', Language::find(Session::get('language')));
            } else {
                $settings->with('langg', Language::where('is_default', '=', 1)->first());
            }

            $settings->with('footer_blogs', DB::table('blogs')->orderby('id','desc')->limit(3)->get());
        });
    }

    public function register()
    {
        Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
            /** @var Collection $collection */
            $collection = $this;
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            $items = $collection->slice(($page - 1) * $perPage, $perPage)->values();
            return new LengthAwarePaginator(
                $items,
                $total ?: $collection->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }
}
