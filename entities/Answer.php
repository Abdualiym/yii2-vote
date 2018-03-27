<?php

namespace abdualiym\vote\entities;

use abdualiym\languageClass\Language;
use abdualiym\vote\entities\entities\User;
//use backend\entities\User;
use abdualiym\vote\entities\queries\AnswerQuery;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "vote_answers".
 * @property integer $id
 * @property integer $question_id
 * @property boolean $status
 * @property boolean $sort
 * @property boolean $created_by
 * @property boolean $updated_by
 * @property boolean $created_at
 * @property boolean $updated_at
 * @property AnswerTranslation[] $translations
 */
class Answer extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_ARCHIVE = 2;

    public static function create($sort, $question_id): self
    {
        $answer = new static();
        $answer->sort = $sort;
        $answer->question_id = $question_id;
        $answer->status = self::STATUS_ARCHIVE;
        return $answer;
    }

    public function edit($sort, $status)
    {
        $this->sort = $sort;
    }

    // status

    public function activate()
    {
        if ($this->isActive()) {
            throw new \DomainException('Answer is already active.');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function draft()
    {
        if ($this->isDraft()) {
            throw new \DomainException('Answer is already draft.');
        }
        $this->status = self::STATUS_DRAFT;
    }

    public function archive()
    {
        if ($this->isArchive()) {
            throw new \DomainException('Answer is already in archive.');
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

    public function isArchive(): bool
    {
        return $this->status == self::STATUS_ARCHIVE;
    }

    // translations

    public function setTranslation($lang_id, $answer)
    {
        $translations = $this->translations;
        foreach ($translations as $tr) {
            if ($tr->isForLanguage($lang_id)) {
                $tr->edit($answer);
                $this->translations = $translations;
                return;
            }
        }
        $translations[] = AnswerTranslation::create($lang_id, $answer);
        $this->translations = $translations;
    }

    public function getTranslation($id): AnswerTranslation
    {
        $translations = $this->translations;
        foreach ($translations as $tr) {
            if ($tr->isForLanguage($id)) {
                return $tr;
            }
        }
        return AnswerTranslation::blank($id);
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
        return $this->hasMany(AnswerTranslation::class, ['answer_id' => 'id']);
    }

    public function Translate($id)
    {
        $lang = Language::getLangByPrefix(\Yii::$app->language);
        $lang_id = $lang['id'];
        $question = AnswerTranslation::find()
            ->where(['answer_id' => $id, 'lang_id' => $lang_id])
            ->one();
        if ($question == null){
            return null;
        }else{
            return $question->answer;
        }

    }


    public function getQuestion(): ActiveQuery
    {
        return $this->hasOne(Question::class, ['id' => 'question_id']);
    }


    // count answer

    public function getCountAnswers()
    {
        return $this->hasMany(Results::class, ['answer_id' => 'id'])->count();
    }



    public function CountResult($id)
    {
        $count = Results::find()
            ->select(['vote_results.id', 'COUNT(vote_results.answer_id) as AnswerCount'])
            ->innerJoin('vote_answers', 'vote_results.answer_id = vote_answers.id')
            ->andWhere(['in', 'vote_results.answer_id', $id])
            ->andWhere(['in', 'vote_answers.status', self::STATUS_ACTIVE])
            ->asArray()
            ->one();
        return $count['AnswerCount'];

    }
    //table name


    public static function tableName()
    {
        return 'vote_answers';
    }


    // behaviors
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

    // transactions

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
    // Query
    public static function find(): AnswerQuery
    {
        return new AnswerQuery(static::class);
    }
}
