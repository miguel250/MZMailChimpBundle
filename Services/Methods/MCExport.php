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

class MCExport extends HttpClient
{

    /**
     * Dump member of a list
     *
     * @return array
     */
    public function DumpList()
    {
       $api = 'export/1.0/list/';
       $payload = array('id' => $this->listId);
       $data = $this->makeRequest($api ,$payload);

       preg_match_all("/\[.*]/",  $data, $result);

       $result = str_replace(array('[',']','"'), "", $result[0]);
       $header = explode(",", $result[0]);
       $reverse =array_reverse($result);
       array_pop($reverse);

       $data = array();
       foreach ($reverse as $value) {
           $member = explode(",", $value);
           $data[] = array_combine($header, $member);
       }

       return $data;
    }

}