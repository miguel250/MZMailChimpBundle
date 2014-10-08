# MZMailChimpBundle
Symfony2 bundle for [MailChimp](http://apidocs.mailchimp.com/api/1.3/index.php) API And [Export API](http://apidocs.mailchimp.com/export/1.0/)

[![Build Status](https://secure.travis-ci.org/miguel250/MZMailChimpBundle.png?branch=master)](http://travis-ci.org/miguel250/MZMailChimpBundle) [![Total Downloads](https://poser.pugx.org/mlpz/mailchimp-bundle/downloads.png)](https://packagist.org/packages/mlpz/mailchimp-bundle) [![Latest Stable Version](https://poser.pugx.org/mlpz/mailchimp-bundle/v/stable.png)](https://packagist.org/packages/mlpz/mailchimp-bundle)

**License**

MZMailChimpBundle is licensed under the MIT License - see the `Resources/meta/LICENSE` file for details

**MailChimp API Method Supported**

1. `listSubscribe`
2. `listUnSubscribe`
3. `listUpdateMember`
4. `listInterestGroupingAdd`
5. `campaignCreate`
6. `campaignSendTest`
7. `campaignSendNow`
8. `listStaticSegmentAdd`
9. `listStaticSegmentMembersAdd`
10. `listStaticSegments`
11. `campaigns`
12. `campaignStats`

**MailChimp Export API Method Supported**

`1. list`

Need support for a method not on the list submit an [issue](MZMailChimpBundle/issues/new)

## Setup

### Step 1: Download MZMailChimpBundle using composer

Add MZMailChimpBundle in your composer.json:

```js
{
    "require": {
        "mlpz/mailchimp-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update mlpz/mailchimp-bundle
```

Composer will install the bundle to your project's `vendor/mlpz` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new MZ\MailChimpBundle\MZMailChimpBundle(),
    );
}
```

### Step 3: Add configuration

``` yml
# app/config/config.yml
mz_mail_chimp:
  api_key: #Mailchimp API Key
  default_list: #default list id
  ssl: true #option to use http or https
```

## Usage

**Using service**

``` php
<?php
        $mailChimp = $this->get('MailChimp');
```

**MailChimp API [Subscribe](http://apidocs.mailchimp.com/api/1.3/listsubscribe.func.php) user to mailing list in a controller**

``` php
<?php
        $mailChimp = $this->get('MailChimp');

        /**
         * Change mailing list
         * */
        $mailChimp->setListID($id);

        /**
         * Get list methods
         * */
        $list = $mailChimp->getList();

        /**
         * listSubscribe default Parameters
         * */
        $list->setMerge($array);  //optional default: null
        $list->setEmailType('html'); //optional default: html
        $list->setDoubleOptin(true);  //optional default : true
        $list->setUpdateExisting(false); // optional default : false
        $list->setReplaceInterests(true);  // optional default : true
        $list->SendWelcome(false);  // optional default : false

        /**
         * Subscribe user to list
         * */
        $list->Subscribe($email); //boolean
```

**MailChimp API [Unsubscribe](http://apidocs.mailchimp.com/api/1.3/listunsubscribe.func.php) remove user from mailing list in a controller**

``` php
<?php
        $mailChimp = $this->get('MailChimp');

        /**
         * Change mailing list
         * */
        $mailChimp->setListID($id);

        /**
         * Get list methods
         * */
        $list = $mailChimp->getList();

        /**
         * UnSubscribe user from list
         * */
        $list->UnSubscribe($email); //boolean
```

**MailChimp API [Update](http://apidocs.mailchimp.com/api/1.3/listupdatemember.func.php) user in a controller**

``` php
<?php
        $mailChimp = $this->get('MailChimp');
        $list = $mailChimp->getList();
        $list->setEmail($oldEmail);
        $list->MergeVars($newEmail);

        /**
        * Update user in mailing list
        **/
        $list->UpdateMember(); //boolean
```

**MailChimp API [Interest Grouping Add](http://apidocs.mailchimp.com/api/rtfm/listinterestgroupingadd.func.php) in a controller**

``` php
<?php
        $mailChimp = $this->get('MailChimp');
        $list = $mailChimp->getList();
        $list->listInterestGroupingAdd(
            $groupTitle, $groupType,
            array($group1, $group2)  
        ); // integer grouping ID
                   
```

**MailChimp API [create campaign](http://apidocs.mailchimp.com/api/1.3/campaigncreate.func.php) in a controller**

``` php
<?php
        $mailChimp = $this->get('MailChimp');
        $campaign = $mailChimp->getCampaign();
        $campaign->setType($type);
        $campaign->setSubject($subject);
        $campaign->setFromEmail($fromEmail);
        $campaign->setFromName($fromName);
        $campaign->setHTML($html);


        $campaign->create(); //return campaign id
```

**MailChimp API [send test campaign](http://apidocs.mailchimp.com/api/1.3/campaignsendtest.func.php) in a controller**

``` php
<?php

        $emails = array('email1','email2');
        $mailChimp = $this->get('MailChimp');
        $campaign = $mailChimp->getCampaign();
        $campaign->SendTest($campaignId, $emails); // return boolean

```

**MailChimp API [send campaign](http://apidocs.mailchimp.com/api/1.3/campaignsendnow.func.php) in a controller**

``` php
<?php
        
        $mailChimp = $this->get('MailChimp');
        $campaign = $mailChimp->getCampaign();
        $campaign->SendNow($campaignId); // return boolean
```

**MailChimp Export API [List](http://apidocs.mailchimp.com/export/1.0/list.func.php)  in controller**

``` php
<?php
       $mailChimp = $this->get('MailChimp');
       $export = $mailChimp->getExport();
       $options = array('status' => 'unsubscribed'); //subscribed, unsubscribed, cleaned
       $export->DumpList($options); //return array

```

**MailChimp API [Listmemberinfo](http://apidocs.mailchimp.com/api/rtfm/listmemberinfo.func.php) in controller**
``` php
<?php
       $mailChimp = $this->get('MailChimp');
       $list = $mailChimp->getList();
       $list->getMemberInfo($email) 
```

**MailChimp API [Import Ecommerce Order](http://apidocs.mailchimp.com/api/1.3/ecommorderadd.func.php) in controller**
``` php
<?php
       $mailChimp = $this->get('MailChimp');
       $ecommerce = $mailChimp->getEcommerce();

       $ecommerce->setOrderId($orderId)
       $ecommerce->setOrderDate($orderDate)
       $ecommerce->setStoreId($storeId)
       $ecommerce->setStoreName($storeName)
       $ecommerce->setCampaignId($mailChimpCampaigId)
       $ecommerce->setShipping($shippingTotal)
       $ecommerce->setTax($taxTotal)
       $ecommerce->setTotal($orderTotal)
       $ecommerce->addItem($productId, $productName, $categoryId, $categoryName, $qty, $cost, $sku)
       
       $ecommerce->addOrder($email) //return boolean
```

**MailChimp API [Delete Ecommerce Order](http://apidocs.mailchimp.com/api/1.3/ecommorderdel.func.php) in controller**
``` php
<?php
       $mailChimp = $this->get('MailChimp');
       $ecommerce = $mailChimp->getEcommerce();
       
       $ecommerce->deleteOrder($storeId, $orderId) //return boolean
```

**MailChimp API [Retrieve Ecommerce Orders](http://apidocs.mailchimp.com/api/1.3/ecommorders.func.php) in controller**
``` php
<?php
       $mailChimp = $this->get('MailChimp');
       $ecommerce = $mailChimp->getEcommerce();
       
       $ecommerce->getOrder($pageStart, $batchLimit, $dateSince) //return array
```

**MailChimp API [create static segment](http://apidocs.mailchimp.com/api/2.0/lists/static-segment-add.php) in a controller**

``` php
<?php

        $mailChimp = $this->get('MailChimp');
	$list = $mailChimp->getList();
        $list->listStaticSegmentAdd('first_segment'); // return int segment id

```

**MailChimp API [segment member add](http://apidocs.mailchimp.com/api/2.0/lists/static-segment-members-add.php) in a controller**

``` php
<?php

        $mailChimp = $this->get('MailChimp');
	$list = $mailChimp->getList();
        $segmentId = $list->listStaticSegmentAdd('first_segment');
	$batch = array('test1@example.com', 'test2@example.com');
	$list->listStaticSegmentMembersAdd($segmentId, $batch);	

```

**MailChimp API [list static segment](http://apidocs.mailchimp.com/api/2.0/lists/static-segments.php) in a controller**

``` php
<?php

        $mailChimp = $this->get('MailChimp');
	$list = $mailChimp->getList();
        $segments = $list->listStaticSegments();

```

**MailChimp API [send campaign to segment] in a controller**

``` php
<?php

        $mailChimp = $this->get('MailChimp');
	$campaign = $mailChimp->getCampaign();
	$list = $mailChimp->getList();
        $segmentId = $list->listStaticSegmentAdd('first_segment');
	$batch = array('test1@example.com', 'test2@example.com');
	$list->listStaticSegmentMembersAdd($segmentId, $batch);	
	$conditions[] = array(
				'field' => 'static_segment',
				'op'    => 'eq',
				'value' => $segmentId
		);

	$segment_options = array(
				'match'      => 'all',
				'conditions' => $conditions
		);
	$campaign->setSegmenOptions($segment_options);
	$campaignId =  $campaign->create();
	$campaign->SendNow($campaignId);

```

**MailChimp API [campaigns](http://apidocs.mailchimp.com/api/rtfm/campaigns.func.php) in a controller**

``` php
<?php

        $mailChimp = $this->get('MailChimp');
	$campaign = $mailChimp->getCampaign();
	//get all campaigns
	$campaign->campaigns();

```
``` php
<?php

        $mailChimp = $this->get('MailChimp');
	$campaign = $mailChimp->getCampaign();
	//filters for example campaign_id, you can all the filters in api website
	$campaign->setFilters(array('campaign_id' => 4589));
	$campaign->campaigns();

```

**MailChimp API [campaignStats](http://apidocs.mailchimp.com/api/rtfm/campaignstats.func.php) in a controller**

``` php
<?php

        $mailChimp = $this->get('MailChimp');
	$campaign = $mailChimp->getCampaign();
        $campaign->campaignStats($campaignId); //return array(),  struct of the statistics for this campaign


```

