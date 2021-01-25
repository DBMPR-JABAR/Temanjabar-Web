<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        View::composer('*', function ($view) {
            $uptd_lists = DB::table('landing_uptd')
            ->get();
             $view->with('uptd_lists', $uptd_lists);
        });
        View::composer('*', function ($view) {
            $user_lists = DB::table('users')->get();
            $view->with('user_lists', $user_lists);
        });
        View::composer('*', function ($view) {
            $ruas_jalan_lists = DB::table('master_ruas_jalan')->get();
            $view->with('ruas_jalan_lists', $ruas_jalan_lists);
        });
        View::composer('*', function ($view) {
            $jembatan_lists = DB::table('master_jembatan')->get();
            $view->with('jembatan_lists', $jembatan_lists);
        });
        View::composer('*', function ($view) {
            $rawan_bencana_lists = DB::table('master_rawan_bencana')->get();
            $view->with('rawan_bencana_lists', $rawan_bencana_lists);
        });
        View::composer('*', function ($view) {
            $cctv_lists = DB::table('cctv')->get();
            $view->with('cctv_lists', $cctv_lists);
        });
    }
}
