<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class LeaveRequest extends ActiveRecord
{
    public static function tableName()
    {
        return 'leave_request';
    }

    public function rules()
    {
        return [
            [['user_id', 'start_date', 'end_date', 'reason'], 'required'],
            [['user_id'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['status'], 'string', 'max' => 50],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
