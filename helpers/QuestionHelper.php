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
            Question::STATUS_ARCHIVE => \Yii::t('app', 'Archive'),
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
            case Question::STATUS_ARCHIVE:
                $class = 'label label-warning';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
    public static function typeLabel($type): string
    {
        switch ($type) {
            case Question::TYPE_ONE:
                $class = 'data:image/png;base64,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';
                break;

            default:
                $class = 'label label-default';
        }

        return Html::tag('img', ArrayHelper::getValue(self::typeList(), $type), [
            'width' => '30',
            'src ' => $class,
        ]);
    }
}