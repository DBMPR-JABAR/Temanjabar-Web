<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



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
            if(Auth::user()){
                $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
                $ruas_jalan_lists_uptd = DB::table('master_ruas_jalan')
                ->where('uptd_id', $uptd_id )
                ->get();
                $view->with('ruas_jalan_lists_uptd', $ruas_jalan_lists_uptd);
            }
        });
        View::composer('*', function ($view) {
            $jembatan_lists = DB::table('master_jembatan')->get();
            $view->with('jembatan_lists', $jembatan_lists);
        });
        View::composer('*', function ($view) {
            if(Auth::user()){
                // $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
                $jembatan_lists_uptd = DB::table('master_jembatan')
                ->where('uptd', Auth::user()->internalRole->uptd )
                ->get();
                $view->with('jembatan_lists_uptd', $jembatan_lists_uptd);
            }
        });
        View::composer('*', function ($view) {
            $rawan_bencana_lists = DB::table('master_rawan_bencana')->get();
            $view->with('rawan_bencana_lists', $rawan_bencana_lists);
        });
        View::composer('*', function ($view) {
            if(Auth::user()){
                $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
                $rawan_bencana_lists_uptd = DB::table('master_rawan_bencana')
                ->where('uptd_id', $uptd_id )
                ->get();
                $view->with('rawan_bencana_lists_uptd', $rawan_bencana_lists_uptd);
            }
        });
        View::composer('*', function ($view) {
            $cctv_lists = DB::table('cctv')->get();
            $view->with('cctv_lists', $cctv_lists);
        });
        View::composer('*', function ($view) {
            if(Auth::user()){
                $uptd_id = str_replace('uptd', '', Auth::user()->internalRole->uptd);
                $cctv_lists_uptd = DB::table('cctv')
                ->where('uptd_id', $uptd_id )
                ->get();
                $view->with('cctv_lists_uptd', $cctv_lists_uptd);
            }
        });
    }
}
