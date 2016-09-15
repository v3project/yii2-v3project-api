New v3project yii2 api
===================================

Info
------------
* http://api.v3project.ru/v5/schema.yaml
* http://jsonviewer.stack.hu/
* http://swagger-ui.v3project.ru/#/
* http://api.v3project.ru/indev.php/v5/product/find?aff_key=

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

add to composer.json
```
"repositories": [
    {
        "type": "git",
        "url":  "https://github.com/v3toys/yii2-v3project-api.git"
    }
],
```

Either run

```
php composer.phar require --prefer-dist v3toys/yii2-v3project-api "*"
```

or add

```
"v3toys/yii2-v3project-api": "*"
```

How to use
----------

```php
//App config
[
    'components'    =>
    [
    //....
        'v3projectApi' =>
        [
            'class'             => 'v3toys\v3project\api\Api',
            'affiliate_key'     => 'fff',
            'timeout'           => 12,
        ],
    //....
    ]
]

```

Examples
----------

```php

$response = \Yii::$app->v3projectApi->send('/product/find', [
    'filters' =>
    [
        'v3p_product_ids' => [3423]
    ]
]);

if ($response->isError)
{
    print_r($response->error_message);
    print_r($response->error_code);
    print_r($response->statusCode);
    print_r($response->requestMethod);
    print_r($response->requestParams);
    print_r($response->requestUrl);
    print_r($response->content);
    print_r($response->api->version);
    print_r($response->api->host);
} else
{
    print_r($response->data);
}

```
___

> [![skeeks!](https://gravatar.com/userimage/74431132/13d04d83218593564422770b616e5622.jpg)](http://skeeks.com)  
<i>SkeekS CMS (Yii2) — fast, simple, effective!</i>  
[skeeks.com](http://skeeks.com) | [cms.skeeks.com](http://cms.skeeks.com) | [marketplace.cms.skeeks.com](http://marketplace.cms.skeeks.com)

