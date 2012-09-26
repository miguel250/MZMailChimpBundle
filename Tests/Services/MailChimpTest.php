<?php

/*
 * This file is part of the MZ\MailChimpBundle
 *
 * (c) Miguel Perez <miguel@mlpz.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MZ\MailChimpBundle\Tests\Services;

use MZ\MailChimpBundle\Services\MailChimp;

/**
 * Test mailchimp
 *
 * @author Miguel Perez <miguel@mlpz.mp>
 */
class MailChimpTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test MailChimp constructor
     * 
     * @covers MZ\MailChimpBundle\Services\MailChimp::__construct
     */
    public function testMailChimpConstruct()
    {
        $mailchimp = new MailChimp('23212312-us2', '12b6c7e6c4');

        $this->assertEquals('23212312-us2', $mailchimp->getAPIkey());
        $this->assertEquals('12b6c7e6c4', $mailchimp->getListID());

    }
    
    /**
     * Test MailChimp constructor
     * 
     * @covers MZ\MailChimpBundle\Services\MailChimp::__construct
     */
    public function testDatacenter()
    {
        $mailchimp = new MailChimp('23212312-us2', '12b6c7e6c4', true);

        $this->assertEquals('https://us2.api.mailchimp.com/', $mailchimp->getDatacenter());
        
        $mailchimp2 = new MailChimp('23212312-us2', '12b6c7e6c4', false);

        $this->assertEquals('http://us2.api.mailchimp.com/', $mailchimp2->getDatacenter());

    }

    /**
     * Test ListID
     *
     * @covers MZ\MailChimpBundle\Services\MailChimp::setListID
     */
    public function testListID()
    {
        $mailchimp = new MailChimp('23212312-us2', '12b6c7e6c5');

        $mailchimp->setListID('12b6c7e6c4');
        $this->assertEquals('12b6c7e6c4', $mailchimp->getListID());
    }
}
