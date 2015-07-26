MvFreeSmsApiBundle
==================

This bundle is for sending notification to your Free Mobile (Require Free Mobile account with api key)

Install
-------

```bash
composer.phar require mv/free-sms-api-bundle
```

Configuration
-------------

Add to your AppKernel

```php
$bundles[] = new Mv\FreeSmsApiBundle\MvFreeSmsApiBundle();
```

Add to config.yml

```yml
mv_free_sms_api:
    users:
        phpmike:
            free_user_id: YOUR USER ID FREE MOBILE
            free_user_api_key: YOUR API KEY FREE MOBILE
        other:
            free_user_id: OTHER USER ID FREE MOBILE
            free_user_api_key: OTHER API KEY FREE MOBILE
```

Examples
--------

```php
$this->get('mv_free_sms_api.sender.phpmike')
            ->addMessage('Test de ce bundle :-)')
            ->send();
```

```php
// Something append in your script
$this->get('mv_free_sms_api.sender.phpmike')->addMessage('There is something wrong with that!');

// Something else append in your script
$this->get('mv_free_sms_api.sender.phpmike')->addMessage('There is something wrong with that other!');
$this->get('mv_free_sms_api.sender.other')->addMessage('There is something wrong with that other!');
// Same as
$this->get('mv_free_sms_api.sender.all')->addMessage('There is something wrong with that other!');
// Same as
$this->get('mv_free_sms_api.sender.all')->addMessageTo('There is something wrong with that other!', array('phpmike', 'other');


// Send messages
$this->get('mv_free_sms_api.sender.all')->send();
```

Be carreful, this throw "Mv\FreeSmsApi\Exception\FailedException" when something went wrong.

Enjoy it!

To be continued...