<?php

namespace abdualiym\vote\helpers;

use abdualiym\vote\entities\Question;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class QuestionHelper
{

    public static function statusList(): array
    {
        return [
            Question::STATUS_DRAFT => \Yii::t('app', 'Draft'),
            Question::STATUS_ACTIVE => \Yii::t('app', 'Active'),
        ];
    }

    public static function typeList(): array
    {
        return [
            Question::TYPE_ONE => \Yii::t('app', 'Select only one option'),
        ];
    }

    public static function typeName($type): string
    {
        return ArrayHelper::getValue(self::typeList(), $type);
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case Question::STATUS_DRAFT:
                $class = 'label label-default';
                break;
            case Question::STATUS_ACTIVE:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}