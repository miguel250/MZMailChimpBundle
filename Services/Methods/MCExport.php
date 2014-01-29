<?php

/*
 * This file is part of the MZ\MailChimpBundle
 *
 * (c) Miguel Perez <miguel@mlpz.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MZ\MailChimpBundle\Services\Methods;

use MZ\MailChimpBundle\Services\HttpClient;

/**
 * Mailchimp Export api
 *
 * @author Miguel Perez <miguel@mlpz.mp>
 * @link   http://apidocs.mailchimp.com/export/1.0/
 */
class MCExport extends HttpClient
{

    /**
     * Dump members of a list
     * 
     * @param $options options
     * @return array
     */
    public function DumpList($options = array())
    {
        $api = 'export/1.0/list/';
        $payload = array_merge(array('id' => $this->listId), $options);
        $data = $this->makeRequest($api, $payload, true);

        $result = preg_split ('/$\R?^/m', $data);

        $headerArray = json_decode($result[0]);
        unset($result[0]);

        $data = array();
        foreach ($result as $value) {
            $data[] = array_combine($headerArray, json_decode($value));
        }

        return $data;
    }

}
