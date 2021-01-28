<?php
        $this->validate($request, [
            'uptd_access' => 'required',
            'user_role' => 'required',
            'menu' => 'required',

        ]);
        // dd($request);
        // dd($data);
            //Delete data
        $menu = DB::table('master_grant_role_aplikasi')
        ->where('internal_role_id',$id)
        ->get();

        for($i=0;$i<count($menu);$i++){
            $role_access = DB::table('utils_role_access')
            ->where('master_grant_role_aplikasi_id',$menu[$i]->id);
            $uptd_access = DB::table('utils_role_access_uptd')
            ->where('master_grant_role_aplikasi_id',$menu[$i]->id);
            $role_access->delete();
            $uptd_access->delete();
        }

        $role_akses = DB::table('master_grant_role_aplikasi')
        ->where('internal_role_id',$id);
        $role_akses->delete();
        // dd($request);
        //Store data 
        
        // $roleExist = DB::table('master_grant_role_aplikasi')->distinct()->pluck('internal_role_id');
        $role_access=array();
        $data = ([
            'user_role'=>$request->user_role,
            'menu'=>$request->menu,
            'uptd_access'=>$request->uptd_access
        ]);
        // dd($data);
       $master_grant['internal_role_id']  = $data['user_role'];
        // echo $data['user_role'];
       for($i=0;$i<count($data['menu']);$i++){
            $ex = explode(".",$data['menu'][$i]);
            array_push($role_access,
                        [
                        'menu'=>$ex[0],
                        'access'=>$ex[1],
                    ]
            );
            $cek = DB::table('master_grant_role_aplikasi')
            ->where(['internal_role_id' => $data['user_role'], 'menu' => $ex[0]])->exists();
            $ko=0;
            // dd( $cek);
            if(!$cek){
                
                $master_grant['menu'] = $ex[0];
                $master_grant['created_date'] = date('Y-m-d H:i:s');
                $master_grant['pointer'] = 0;
                DB::table('master_grant_role_aplikasi')->insert($master_grant);
                $ko=1;
            }else{

                $masters= DB::table('master_grant_role_aplikasi as a')
                ->select('a.id')
                ->where(['a.internal_role_id' => $data['user_role'], 'a.menu' => $ex[0]])
                ->where('a.pointer',1)
                ->get();
                $masers_id= $masters[0]->id;
                $pointer['pointer']=0;
                DB::table('master_grant_role_aplikasi')->where('id',$masers_id)->update($pointer);
                
            }
            $master= DB::table('master_grant_role_aplikasi as a')
            ->select('a.id')
            ->where('a.internal_role_id',$data['user_role'])
            ->where('a.pointer',0)
            ->get();
            
            $maser_id= $master[0]->id;
            $role_access_list['master_grant_role_aplikasi_id'] = $maser_id;
            $role_access_list['role_access'] = $ex[1];
            DB::table('utils_role_access')->insert($role_access_list);
            $pointer['pointer']=1;
            DB::table('master_grant_role_aplikasi')->where('id',$maser_id)->update($pointer);
            if($cek){
                for($j=0;$j<count($data['uptd_access']);$j++){
                    $uptd_access_list['uptd_name'] = $data['uptd_access'][$j];
                    $uptd_access_list['master_grant_role_aplikasi_id'] = $maser_id;
                    DB::table('utils_role_access_uptd')->insert($uptd_access_list);
                }
            }
                
            
       }
       $color = "success";
        $msg = "Edit Data Grant Access Role Aplikasi";
        return redirect()->route('getRoleAkses')->with(compact('color', 'msg'));