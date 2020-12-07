<?php


use Illuminate\Support\Facades\DB;

/**
 * hasAccess
 *
 * true if exists, false if not exists
 *
 * @param int $role_id --> User->internal_role_id
 * @param string $menu --> arbitrary
 * @param string $access --> [view, create, update, delete]
 * @return bool
 **/
function hasAccess($role_id, $menu, $access){
    $grantRole = DB::table('master_grant_role_aplikasi')
                    ->where(['internal_role_id' => $role_id, 'menu' => $menu])->first();
    if($grantRole){
        return DB::table('utils_role_access')
                ->where(['master_grant_role_aplikasi_id' => $grantRole->id, 'role_access' => $access])
                ->exists();
    }

    return false;
}

/**
 * uptdAccess
 *
 * return list uptd
 *
 * @param int $role_id --> User->internal_role_id
 * @param string $menu --> arbitrary
 * @return Array
 **/
function uptdAccess($role_id, $menu){
    $uptd = [];

    $grantRole = DB::table('master_grant_role_aplikasi')
                    ->where(['internal_role_id' => $role_id, 'menu' => $menu])->first();
    if($grantRole){
        $uptd = DB::table('utils_role_access_uptd')
                  ->where(['master_grant_role_aplikasi_id' => $grantRole->id])
                  ->pluck('uptd_name')->toArray();
    }

    return $uptd;
}



