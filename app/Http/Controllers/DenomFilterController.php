<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class DenomFilterController extends Controller
{
    public function __invoke($filterAmount = 50000)
    {
        if (!is_numeric($filterAmount)) {
            $filterAmount = 50000;
        }

        $json = self::loadJson();

        $denoms = [];

        if (isset($json['status']) && $json['status'] == 1 && isset($json['data']['response']['billdetails'])) {

            $billDetails = $json['data']['response']['billdetails'];
            
            foreach ($billDetails as $billDetail) {

                $denomString = $billDetail['body'][0];
                $denomString = str_replace(' ', '', $denomString);

                $denomArray = explode(':', $denomString);

                if (isset($denomArray[1]) && is_numeric($denomArray[1]) && $denomArray[1] > $filterAmount) {
                    $denoms[] = (int) $denomArray[1];
                }
            }
        }
        
        return $denoms;
    }

    private static function loadJson() : array
    {
        $jsonString = Storage::get('denom.json');
        return json_decode($jsonString, true);
    }
}
