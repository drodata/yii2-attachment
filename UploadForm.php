<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use alexgx\phpexcel\PhpExcel;
use common\models\Excel;
use backend\models\Rate;

class UploadForm extends Model
{
    public $key; // 各个模型的主键值
    public $files;
    
    public $modelClass = '\backend\models\Media';
    public $modelFkName = 'media_id';
    public $viewPath = '@backend/views/upload';

	const SCENARIO_ORDER_CONTRACT = 'order-contract';
	const SCENARIO_CUSTOMER_AGREEMENT = 'customer-agreement';

    public function rules()
    {
        return [
            [
                'files',
                'image',
                'extensions' => ['png', 'jpg'],
                'skipOnEmpty' => false,
                'skipOnError' => false,
                'maxFiles' => 2,
                'on' => self::SCENARIO_ORDER_CONTRACT,
            ],

            [
                'files',
                'image',
                'extensions' => ['png', 'jpg'],
                'skipOnEmpty' => false,
                'skipOnError' => false,
                'maxFiles' => 2,
                'on' => self::SCENARIO_CUSTOMER_AGREEMENT,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        switch ($this->scenario) {
            case self::SCENARIO_ORDER_CONTRACT:
                $files = '订单合同图片';
                break;
            case self::SCENARIO_CUSTOMER_AGREEMENT:
                $files = '月结协议图片';
                break;
            default:
                $files = '图片';
                break;
        }

        return [
            'files' => $files,
        ];
    }

    public function getUploadParams()
    {
        switch ($this->scenario) {
            case self::SCENARIO_CUSTOMER_AGREEMENT:
                $attributes = [
                    'type' => Media::TYPE_IMAGE,
                    'category' => Media::CATEGORY_CUSTOMER_AGREEMENT,
                ];
                $junctionModelClass = '\backend\models\CustomerAgreement';
                $junctionAttribute = 'company_id';
                break;
        }

        return [$attributes, $junctionModelClass, $junctionAttribute];
    }
    protected function uploadAttachment()
    {
        list($attributes, $junctionModelClass, $junctionAttribute) = $this->getUploadParams();

        foreach ($this->files as $file) {
            $modelClass = $this->modelClass;
            $media = new $modelClass($attributes);
            $media->name = $file->name;
            $media->storeFile($file);

            if (!$media->save()) {
                throw new \yii\db\Exception($media->stringifyErrors());
            }

            $junction = new $junctionModelClass([
                $junctionAttribute => $this->key,
                $this->modelFkName => $media->id,
            ]);

            if (!$junction->save()) {
                throw new \yii\db\Exception($junction->stringifyErrors());
            }
        }
    }
	public function upload()
	{
        if (!$this->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->uploadAttachment();
            $transaction->commit();
            return true;
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}

