<?php

function sendNotification($title, $body, $target, $type, $extraId = null, $response) {
    $users_token = [];
    $tokens = [];
    $status = $response['status'];

    if($type == 1) {
        $permintaan_pengeluaran_barang = \App\PermintaanPengeluaranBarang::find($extraId);
        $aset = $permintaan_pengeluaran_barang->aset;
        foreach($aset as $a) {
            \App\TrackingAset::create([
                'aset_id' => $a->id,
                'title' => $title,
                'body' => $body
            ]);
        }
    } else if ($type == 7) {
        \App\TrackingAset::create([
            'aset_id' => $extraId,
            'title' => $title,
            'body' => $body
        ]);

        $aset = \App\Aset::find($extraId);
        $extraId = $aset->permintaan_pengeluaran_barang_id;
    } else if($type == 8) {
        foreach($extraId as $id) {
            $trackingAset = \App\TrackingAset::where('aset_id', $id)->orderBy('id', 'desc')->first();
            if($trackingAset->title != $title) {
                \App\TrackingAset::create([
                    'aset_id' => $id,
                    'title' => $title,
                    'body' => $body
                ]);
            }
        }
        
    } else {
        \App\TrackingAset::create([
            'aset_id' => $extraId,
            'title' => $title,
            'body' => $body
        ]);
    }



    if(is_array($target)) {
        $users = \App\User::whereIn('id', $target)->get();
        
        foreach($users as $user) {
            if($user) {
                $tokens = $user->firebaseToken->map(function($f) {
                    return $f->token;
                })->toArray();
                $users_token = array_merge($users_token, $tokens);

                \App\Notification::create([
                    'user_id' => $user->id,
                    'title' => $title,
                    'body' => $body,
                    'type' => $type,
                    'is_read' => 0,
                    'extra_id' => $extraId
                ]);
            }

            
        }
    } else {
        $user = \App\User::findOrFail($target);
        $tokens = $user->firebaseToken->map(function($f) {
            return $f->token;
        })->toArray();
        
        \App\Notification::create([
            'user_id' => $user->id,
            'title' => $title,
            'body' => $body,
            'type' => $type,
            'is_read' => 0,
            'extra_id' => $extraId
        ]);
    }

    $client = new \GuzzleHttp\Client();

    if(is_array($target)) {
        if(count($users_token) == 0) {
            echo json_encode($response['data']);
            return ;
        } else {
            $client->request('POST', 'https://fcm.googleapis.com/fcm/send', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'key=AAAAlO9NSVA:APA91bEdOrOsNhVD5R-aBbQz9j5elJEvdBf-cwuI57dH5JVW8ZFgk68StKRgKFOz257MqCMEceJtwU65eB1yLXQ3aznfaPZ686K-eHNu-UefPZ1XPdPR7HpDO4KxUp7sZT67QWRgc34b'
                ],
                'json' => [
                    'data' => [
                        "title" => $title,
                        "body" => $body,
                        "type" => $type,
                        "extraId" => $extraId
                    ],
                    'registration_ids' => $users_token
                ],
            ]);
        }
    } else {
        $client->request('POST', 'https://fcm.googleapis.com/fcm/send', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'key=AAAAlO9NSVA:APA91bEdOrOsNhVD5R-aBbQz9j5elJEvdBf-cwuI57dH5JVW8ZFgk68StKRgKFOz257MqCMEceJtwU65eB1yLXQ3aznfaPZ686K-eHNu-UefPZ1XPdPR7HpDO4KxUp7sZT67QWRgc34b'
            ],
            'json' => [
                'data' => [
                    "title" => $title,
                    "body" => $body,
                    "type" => $type,
                    "extraId" => $extraId
                ],
                'registration_ids' => $tokens
            ],
        ]);
    }

    header('Content-Type: application/json');
    header("HTTP/1.1 $status OK");
    echo json_encode($response['data']);
}