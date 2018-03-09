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
 * This is the model class for table "vote_answers".
 *
 * @property integer $id
 * @property integer $vote_id
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

    public static function create($sort, $vote_id): self
    {
        $answer = new static();
        $answer->sort = $sort;
        $answer->vote_id = $vote_id;
        $answer->status = self::STATUS_ACTIVE;
        return $answer;
    }

    public function edit($sort)
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
    public static function find(): VotesQuery
    {
        return new VotesQuery(static::class);
    }
}
