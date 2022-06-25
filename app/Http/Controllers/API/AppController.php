<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;


class AppController extends Controller
{
public function getVersion()
{
    return response()->json([
        'appName' => 'siperlajar',
        'packageName'=>'com.siperlajar.sipelajar',
        'version' => '1.0.0',
        'build' => '1',
        'buildSignature' => '0D7C367E726EC9B5E129AE8E96C79D6AED776B60',
        'ReleaseNotes' => 'Minor update and bug fixes',
        'downloadUrl' => route('app.download'),
    ]);
}

public function download()
{
    $file = public_path('app/download/sipelajar_1.0.2.apk');
    
    return Response::download($file, 'sipelajar_1.0.2.apk', [
        'Content-Type' => 'application/vnd.android.package-archive',

    ]);
}



}
