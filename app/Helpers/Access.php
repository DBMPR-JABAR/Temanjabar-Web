<?php


use Illuminate\Support\Facades\DB;
use App\Model\Push\UserPushNotification;
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

function pushNotification($users, $title, $body)
    {
        $firebaseToken = UserPushNotification::whereNotNull('device_token')->whereIn('user_id',$users)->pluck('device_token')->all();
        $SERVER_API_KEY = 'AAAAKK9GKAE:APA91bELNXXSrX8VS-g7stPhlSLM_JP6JtzgFgkL0EyvPtk2qlCGWB0lAOteWN8SelfYoql5JuTI00bcD4ACcW2aHRr1WXudiwR9mtaEMwOehhtyCfMqIABa3PcijBDJbsyn-u9jPE1V';
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $title,
                "body" => $body,
            ],
            "data" => [
                "click_action" => "FLUTTER_NOTIFICATION_CLICK"
            ]
        ];
        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
        // if ($response === FALSE) {
        //     die('Curl failed: ' . curl_error($ch));
        // }
        curl_close ( $ch );
        return $response;
    }

function pushNotificationDebug()
{
    $firebaseToken = UserPushNotification::whereNotNull('device_token')->pluck('device_token')->all();
    $SERVER_API_KEY = 'AAAAKK9GKAE:APA91bELNXXSrX8VS-g7stPhlSLM_JP6JtzgFgkL0EyvPtk2qlCGWB0lAOteWN8SelfYoql5JuTI00bcD4ACcW2aHRr1WXudiwR9mtaEMwOehhtyCfMqIABa3PcijBDJbsyn-u9jPE1V';
    $data = [
        "registration_ids" => $firebaseToken,
        "notification" => [
            "title" => "Sample Notification",
            "body" => "Lorem ipsum solor dit amet",
        ],
        "data" => [
            "click_action" => "FLUTTER_NOTIFICATION_CLICK"
        ]
    ];
    $dataString = json_encode($data);
    $headers = [
        'Authorization: key=' . $SERVER_API_KEY,
        'Content-Type: application/json',
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
    $response = curl_exec($ch);
    return $response;

}



