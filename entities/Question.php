<?php

namespace abdualiym\vote\entities;

use abdualiym\languageClass\Language;
use abdualiym\vote\entities\queries\VotesQuery;
use abdualiym\vote\entities\entities\User;
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
 * @property integer $type
 * @property boolean $created_at
 * @property boolean $updated_at
 * @property QuestionTranslation[] $translations
 */
class Question extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    const TYPE_STRING = 1;
    const TYPE_INTEGER = 2;
    const TYPE_FLOAT = 3;

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
        return $this->hasMany(QuestionTranslation::class, ['question_id' => 'id']);
    }

    public function Translate($id)
    {
        $lang = Language::getLangByPrefix(\Yii::$app->language);
        $lang_id = $lang['id'];
        $question = QuestionTranslation::find()->where(['question_id' => $id, 'lang_id' => $lang_id])->one();
        if ($question == null){
            return null;
        }else{
            return $question->question;
        }

    }

    public function getVoteAnswers(): ActiveQuery
    {
        return $this->hasMany(Answer::class, ['question_id' => 'id']);
    }

    public function getResultsUserVote(): ActiveQuery
    {
        return $this->hasOne(Results::class, ['question_id' => 'id'])->where(['user_ip'=> \Yii::$app->getRequest()->getUserIP()]);
    }

    public function getResultsUserAnswer(): ActiveQuery
    {
        return $this->hasMany(Results::class, ['answer_id' => 'id']);
    }

    public function getResultInfo(): ActiveQuery
    {
        $ip = \Yii::$app->getRequest()->getUserIP();
        return $this->hasOne(Results::class, ['question_id' => 'id'])->where(['user_ip' => $ip]);
    }


    public function VoteQuestion($id)
    {
        return QuestionTranslation::find()->where(['question_id' => $id, 'lang_id' => 1])->one();
    }

    // table name

    public static function tableName()
    {
        return 'vote_questions';
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
