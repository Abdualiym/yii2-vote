Votes modul for yii2
====================
Votes modul for yii2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist abdualiym/yii2-vote "*"
```

or add

```
"abdualiym/yii2-vote": "*"
```

to the require section of your `composer.json` file.

Config

```
 'modules' => [
        'vote' => [
            'class' => 'abdualiym\vote\Vote',
        ],
    ],
    
```

- add to backend config:
```php
'controllerMap' => [
    'answer' => [
        'class' => 'abdualiym\vote\controllers\AnswerController',
    ],
    'question' => [
        'class' => 'abdualiym\vote\controllers\QuestionController',
    ],
],
```



Params
```
    'languages' => ['ru', 'en'],
```

Usage
-----

Once the extension is installed, simply use it in your code by  :

```
     <? echo \frontend\widgets\vote\Vote::widget(); ?>
```
# yii2-vote
