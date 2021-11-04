<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%logs}}".
 *
 * @property int $id
 * @property string $endpoint
 * @property string $okada_endpoint
 * @property string|null $incoming_params
 * @property string|null $okada_response
 * @property string|null $response
 * @property string|null $incoming_timestamp
 * @property string|null $okada_response_timestamp
 * @property string|null $response_timestamp
 * @property string|null $ip_address
 */
class Logs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%logs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['incoming_timestamp', 'okada_response_timestamp', 'response_timestamp'], 'safe'],
            [['endpoint', 'okada_endpoint'], 'string', 'max' => 512],
            [['incoming_params', 'okada_response', 'response'], 'string', 'max' => 255],
            [['ip_address'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'endpoint' => Yii::t('app', 'Endpoint'),
            'okada_endpoint' => Yii::t('app', 'Okada Endpoint'),
            'incoming_params' => Yii::t('app', 'Incoming Params'),
            'okada_response' => Yii::t('app', 'Okada Response'),
            'response' => Yii::t('app', 'Response'),
            'incoming_timestamp' => Yii::t('app', 'Incoming Timestamp'),
            'okada_response_timestamp' => Yii::t('app', 'Okada Response Timestamp'),
            'response_timestamp' => Yii::t('app', 'Response Timestamp'),
            'ip_address' => Yii::t('app', 'Ip Address'),
        ];
    }
}
