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
        var_dump($payload);
        $data = $this->makeRequest($api, $payload, true);

        preg_match_all("/\[.*]/", $data, $result);

        $result = str_replace(array('[', ']', '"'), "", $result[0]);
        $header = explode(",", $result[0]);
        unset($result[0]);

        $data = array();
        foreach ($result as $value) {
            $member = explode(",", $value);
            $data[] = array_combine($header, $member);
        }

        return $data;
    }

}
