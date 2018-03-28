<?php

namespace abdualiym\vote;

use yii\base\BootstrapInterface;
use Yii;

/**
 * Vote module bootstrap class.
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // Add module URL rules.
        Yii::$app->urlManager->addRules(
            [
                'voteresult' => 'site/vote-result',
                'vote/<_c:[\w\-]+>/<_a:[\w-]+>' => 'vote/<_c>/<_a>',
            ],
            false
        );

        // Add module I18N category.
        if (!isset($app->i18n->translations['vote']) && !isset($app->i18n->translations['vote*'])) {
            $app->i18n->translations['vote'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@abdualiym/vote/messages',
                'sourceLanguage' => 'en',
                'forceTranslation' => true,
            ];
        }
    }
}
