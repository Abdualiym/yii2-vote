<?php

namespace abdualiym\vote\helpers;

use abdualiym\vote\entities\Answer;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class AnswerHelper
{

    public static function statusList(): array
    {
        return [
            Answer::STATUS_DRAFT => \Yii::t('app', 'Draft'),
            Answer::STATUS_ACTIVE => \Yii::t('app', 'Active'),
            Answer::STATUS_ARCHIVE => \Yii::t('app', 'Archive'),

        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case Answer::STATUS_DRAFT:
                $class = 'label label-default';
                break;
            case Answer::STATUS_ACTIVE:
                $class = 'label label-success';
                break;
            case Answer::STATUS_ARCHIVE:
                $class = 'label label-warning';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}