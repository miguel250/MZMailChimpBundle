# MZMailChimpBundle
Symfony2 bundle for [MailChimp](http://apidocs.mailchimp.com/api/1.3/index.php) API And [Export API](http://apidocs.mailchimp.com/export/1.0/)
[![Build Status](https://secure.travis-ci.org/miguel250/MZMailChimpBundle.png?branch=master)](http://travis-ci.org/miguel250/MZMailChimpBundle)

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

**MailChimp Export API Method Supported**

`1. list`

Need support for a method not on the list submit an [issue](MZMailChimpBundle/issues/new)

## Setup
**Using Submodule**

    git submodule add https://github.com/miguel250/MZMailChimpBundle.git vendor/bundles/MZ/MailChimpBundle
    git submodule add https://github.com/kriswallsmith/Buzz.git  vendor/buzz
**Using the vendors script**

      [MZMailChimpBundle]
          git=https://github.com/miguel250/MZMailChimpBundle.git
          target=bundles/MZ/MailChimpBundle
      [buzz]
          git=https://github.com/kriswallsmith/Buzz.git
          target=buzz/
**Add the MZ namespace to autoloader**

``` php
<?php
   // app/autoload.php
   $loader->registerNamespaces(array(
    // ...
    'MZ'               => __DIR__.'/../vendor/bundles',
    'Buzz'             => __DIR__.'/../vendor/buzz/lib',
  ));
```
**Add MZMailChimpBundle to your application kernel**

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
**Yml configuration**

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