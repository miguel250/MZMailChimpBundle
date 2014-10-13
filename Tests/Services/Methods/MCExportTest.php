<?php
/*
 * This file is part of the MZ\MailChimpBundle
 *
 * (c) Miguel Perez <miguel@mlpz.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
use MZ\MailChimpBundle\Services\HttpClient;
use MZ\MailChimpBundle\Services\Methods\MCExport;
/**
 * Test Mailchimp Export Class
 *
 * @author Miguel Perez <miguel@mlpz.mp>
 */
class MCExportTest extends \PHPUnit_Framework_TestCase
{
    public function testDumpList()
    {
        $expect = array(
            0 => array(
                'Email Address' => 'test@gmail.com',
                'First Name' => 'test',
                'Last Name' => 'test',
                'Skills' => 'Both',
                'testing' => '',
                'MEMBER_RATING' => 2,
                'OPTIN_TIME' => '2012-07-03 21:47:23',
                'OPTIN_IP' => '24.189.148.246',
                'CONFIRM_TIME' => '2012-07-03 21:47:31',
                'CONFIRM_IP' => '24.189.148.246',
                'LATITUDE' => '40.8090000',
                'LONGITUDE' => '-73.9168000',
                'GMTOFF' => '-5',
                'DSTOFF' => '-4',
                'TIMEZONE' => 'America/New_York',
                'CC' => 'US',
                'REGION' => 'NY',
                'LAST_CHANGED' => '2012-07-03 21:47:31'
                )
            );

        $export = $this->getMock('MZ\MailChimpBundle\Services\Methods\MCExport',
            array('makeRequest'),
            array(),
            '',
            false,
            false,
            true);

        $reponse = <<<EOD
["Email Address","First Name","Last Name","Skills","testing","MEMBER_RATING","OPTIN_TIME","OPTIN_IP","CONFIRM_TIME","CONFIRM_IP","LATITUDE","LONGITUDE","GMTOFF","DSTOFF","TIMEZONE","CC","REGION","LAST_CHANGED"]
["test@gmail.com","test","test","Both","",2,"2012-07-03 21:47:23","24.189.148.246","2012-07-03 21:47:31","24.189.148.246","40.8090000","-73.9168000","-5","-4","America\/New_York","US","NY","2012-07-03 21:47:31"]
EOD;
        $export->expects($this->any())->method('makeRequest')->will($this->returnValue($reponse));
        $dump = $export->DumpList();
        
        $this->assertEquals($expect, $dump);
    }
}
