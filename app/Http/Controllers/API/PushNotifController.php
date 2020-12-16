<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Push\UserPushNotification;
use Illuminate\Http\Request;

class PushNotifController extends Controller
{

    private $response;
    public function __construct() {
        $this->response = [
            'status' => 'false',
            'data' => []
        ];
    }

    public function index()
    {
        return view('debug.push-notif');
    }

    public function saveToken(Request $request)
    {
        try {
            $userPushNotif = UserPushNotification::updateOrCreate(
                ['user_id' => $request->user_id],
                ['device_token' => $request->token]
            );

            $this->response['status'] = 'success';
            $this->response['data']['message'] =  "Token Saved";

            return response()->json($this->response, 200);
        } catch (\Exception $th) {
            $this->response['data']['message'] = 'Internal Error';
            return response()->json($this->response, 500);
        }
    }

    // TODO: Let's Keep this in helper
    public function sendNotification(Request $request)
    {
        $firebaseToken = UserPushNotification::whereNotNull('device_token')->pluck('device_token')->all();
        $SERVER_API_KEY = 'AAAAKK9GKAE:APA91bELNXXSrX8VS-g7stPhlSLM_JP6JtzgFgkL0EyvPtk2qlCGWB0lAOteWN8SelfYoql5JuTI00bcD4ACcW2aHRr1WXudiwR9mtaEMwOehhtyCfMqIABa3PcijBDJbsyn-u9jPE1V';
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
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
        dd($response);
    }

    public function debugNotification(Request $request)
    {
        $firebaseToken = UserPushNotification::whereNotNull('device_token')->pluck('device_token')->all();
        $SERVER_API_KEY = 'AAAAKK9GKAE:APA91bELNXXSrX8VS-g7stPhlSLM_JP6JtzgFgkL0EyvPtk2qlCGWB0lAOteWN8SelfYoql5JuTI00bcD4ACcW2aHRr1WXudiwR9mtaEMwOehhtyCfMqIABa3PcijBDJbsyn-u9jPE1V';
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => "Sample Notification",
                "body" => "Lorem ipsum solor dit amet",
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
        dd($response);
    }

}
