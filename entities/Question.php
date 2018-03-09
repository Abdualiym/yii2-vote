<?php

namespace abdualiym\vote\entities;

use common\models\User;
use abdualiym\vote\entities\queries\VotesQuery;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "vote_votes".
 * @property integer $id
 * @property boolean $created_by
 * @property boolean $updated_by
 * @property integer $sort
 * @property boolean $created_at
 * @property boolean $updated_at
 * @property QuestionTranslation[] $translations
 */
class Question extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    public static function create($type): self
    {
        $question = new static();
        $question->type = $type;
        $question->status = self::STATUS_ACTIVE;
        return $question;
    }

    public function edit($type)
    {
        $this->type = $type;
    }

    // Status

    public function activate()
    {
        if ($this->isActive()) {
            throw new \DomainException('Slide is already active.');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function draft()
    {
        if ($this->isDraft()) {
            throw new \DomainException('Slide is already draft.');
        }
        $this->status = self::STATUS_DRAFT;
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isDraft(): bool
    {
        return $this->status == self::STATUS_DRAFT;
    }


    // translations

    public function setTranslation($lang_id, $question)
    {
        $translations = $this->translations;
        foreach ($translations as $tr) {
            if ($tr->isForLanguage($lang_id)) {
                $tr->edit($question);
                $this->translations = $translations;
                return;
            }
        }
        $translations[] = QuestionTranslation::create($lang_id, $question);
        $this->translations = $translations;
    }

    // main function for translation columns

    public function getTranslation($id): QuestionTranslation
    {
        $translations = $this->translations;
        foreach ($translations as $tr) {
            if ($tr->isForLanguage($id)) {
                return $tr;
            }
        }
        return QuestionTranslation::blank($id);
    }


    // relations

    public function getCreatedBy(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }


    public function getUpdatedBy(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    public function getTranslations(): ActiveQuery
    {
        return $this->hasMany(QuestionTranslation::class, ['vote_id' => 'id']);
    }

    public function getVoteAnswers(): ActiveQuery
    {
        return $this->hasMany(Answer::class, ['vote_id' => 'id']);
    }

    public function getResultsUserVote(): ActiveQuery
    {
        return $this->hasOne(Results::class, ['question_id' => 'id'])->where(['user_ip'=> \Yii::$app->getRequest()->getUserIP()]);
    }

    public function getResultsUserAnswer(): ActiveQuery
    {
        return $this->hasMany(Results::class, ['answer_id' => 'id']);
    }


    public function VoteQuestion($id)
    {
        return QuestionTranslation::find()->where(['vote_id' => $id, 'lang_id' => \Yii::$app->language])->one();
    }

    // table name

    public static function tableName()
    {
        return 'vote_votes';
    }

    //behaviors

    public function behaviors(): array
    {
        return [
            BlameableBehavior::className(),
            TimestampBehavior::className(),
            [
                'class' => SaveRelationsBehavior::className(),
                'relations' => ['translations'],
            ],
        ];
    }

    //transactions

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    // query

    public static function find(): VotesQuery
    {
        return new VotesQuery(static::class);
    }
}
