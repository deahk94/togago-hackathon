<?php

namespace app\forms;

use Yii;
use yii\base\Model;

class CtripForm extends Model
{
    public $id;
    public $url   = "https://hotels-com-provider.p.rapidapi.com/";
    public $start_date     = "2022-03-01";
    public $end_date       = "2022-03-05";
    public $sort_order     = "PRICE";
    public $destination_id = "908873"; //KL
    public $adults_number  = 1;
    public $locale         = "en_US";
    public $currency       = "MYR";
    public $city           = "KualaLumpur";
    public $lon            = "";
    public $lat            = "";

    /**
     * $sort_order option have
     * STAR_RATING_HIGHEST_FIRST,
     * STAR_RATING_LOWEST_FIRST,
     * BEST_SELLER,
     * DISTANCE_FROM_LANDMARK,
     * GUEST_RATING,
     * PRICE_HIGHEST_FIRST,
     * PRICE
     */
    public function rules()
    {
        return [
            [['id', 'url', 'start_date', 'end_date', 'sort_order', 'destination_id', 'adults_number', 'locale', 'currency', 'city', 'lon', 'lat'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
        ];
    }
    
    public function seach_hotel()
    {
        $curl    = curl_init();
        $api_url = $this->url . "v1/hotels/search?" .
                "checkin_date=" . $this->start_date .
                "&checkout_date=" . $this->end_date .
                "&sort_order=" . $this->sort_order .
                "&destination_id=" . $this->destination_id .
                "&adults_number=" . $this->adults_number .
                "&locale=" . $this->locale .
                "&currency=" . $this->currency;

        curl_setopt_array($curl, [
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: hotels-com-provider.p.rapidapi.com",
                "x-rapidapi-key: 88f564c635mshb503a379ea219e4p1a79dbjsn74b42b11c4d0"
            ],
        ]);

        $response  = curl_exec($curl);
        $json_resp = json_decode($response);
        $err       = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            Yii::Warning(var_export($json_resp, true));
        }
    }

    public function search_destination()
    {
        $curl    = curl_init();
        $api_url = $this->url . "v1/destinations/search?" .
                "query=" . $this->city .
                "&locale=" . $this->locale .
                "&currency=" . $this->currency;
        curl_setopt_array($curl, [
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: hotels-com-provider.p.rapidapi.com",
                "x-rapidapi-key: 88f564c635mshb503a379ea219e4p1a79dbjsn74b42b11c4d0"
            ],
        ]);

        $response  = curl_exec($curl);
        $json_resp = json_decode($response);
        $err       = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            Yii::Warning(var_export($json_resp, true));
        }
    }

    public function search_nearby_hotel()
    {  
        $this->get_lon_lat();
        
        $curl    = curl_init();
        $api_url = $this->url . "v1/hotels/nearby?" .
                "latitude=" . $this->lat .
                "&longitude=" . $this->lon .
                "&checkin_date=" . $this->start_date .
                "&checkout_date=" . $this->end_date .
                "&sort_order=" . $this->sort_order .
                "&destination_id=" . $this->destination_id .
                "&adults_number=" . $this->adults_number .
                "&locale=" . $this->locale .
                "&currency=" . $this->currency;

        curl_setopt_array($curl, [
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: hotels-com-provider.p.rapidapi.com",
                "x-rapidapi-key: 88f564c635mshb503a379ea219e4p1a79dbjsn74b42b11c4d0"
            ],
        ]);

        $response  = curl_exec($curl);
        $json_resp = json_decode($response);
        $err       = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            Yii::Warning(var_export($json_resp, true));
        }
    }

    public function get_lon_lat()
    {
        $url = "https://geoip.aposcb.org/api/";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        $json_resp = json_decode($resp);

        $this->lat = $json_resp->lat;
        $this->lon = $json_resp->lon;
    }
}
