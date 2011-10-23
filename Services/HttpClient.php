<?php

/*
 * This file is part of the MZ\MailChimpBundle
 *
 * (c) Miguel Perez <miguel@mlpz.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MZ\MailChimpBundle\Services;

class HttpClient
{
    protected $url = "http://us2.api.mailchimp.com/1.3/";
    protected $apiKey;

    /**
     * Send API request to mailchimp
     *
     * @return array
     */
    protected function makeRequest($type, $payload)
    {
        $payload['apikey'] = $this->apiKey;
        $data = json_encode($payload);
        $url = $this->url . '?method=' . $type;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "MZMailChimpBundle");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($data));

        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result);

        if (!empty($data->error)) {
            throw new \Exception("$data->code $data->error");
        } else {
            return $data;
        }
    }

}