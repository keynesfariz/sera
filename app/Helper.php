<?php

namespace App;

class Helper
{
    public static function response($data = null, $withTotal = null, $errorStatus = 1, $message = 'Success', $statusCode = 200)
    {
        $json = [
            'status' => $errorStatus,
            'message' => $message
        ];

        if (isset($data)) {

            if ($withTotal) {
                $json['total'] = count($data);
            }
            
            $json['data'] = $data;
        }

        return response()
            ->json($json)
            ->setStatusCode($statusCode);
    }
}
