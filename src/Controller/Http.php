<?php

namespace App\Controller;

use GuzzleHttp\Client;

class Http
{
    public static function doRequest($url, $method)
    {
        $client = new Client();
        $res = $client->request(
            $method,
            $url
        );

        return json_decode($res->getBody(), true);
    }
}