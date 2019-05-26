<?php

namespace App\Entity;

use App\Controller\Http;

class Joke
{
    const URL_JOKE = 'http://api.icndb.com/jokes/';
    const URL_CATEGORIES = 'http://api.icndb.com/categories';
    const METHOD = 'POST';


    public static function setJoke($categories)
    {
        $src_data = Http::doRequest(self::URL_JOKE, self::METHOD);

        $processed_data = [];

        foreach ($src_data as $key => $value) {
            if (strcasecmp($key, 'value') == 0) {
                foreach ($value as $val) {
                    if (!empty($val['categories']) && !empty($categories)) {
                        if (strcasecmp($val['categories'][0], $categories) == 0) {
                            $processed_data[] = $val['joke'];
                        }
                    }
                }
            }
        }

        if (!empty($processed_data)) {
            $rand_keys = array_rand($processed_data);

            return $processed_data[$rand_keys];
        } else {
            return '';
        }
    }

    public static function setCategories()
    {
        $src_data = Http::doRequest(self::URL_CATEGORIES, self::METHOD);
        $processed_data = [];

        foreach ($src_data as $key => $value) {
            if (strripos($key, 'value') !== false) {
                foreach ($value as $val) {
                    $processed_data[$val] = $val;
                }
            }
        }

        $processed_data[''] = null;

        return array_unique($processed_data);
    }
}