<?php

namespace dro\attachment;

use Yii;
use yii\base\Model;

class UploadForm extends Model
{
    public $key; // 各个模型的主键值
    public $files;
    
    public $modelClass;
    public $modelFkName;
    public $viewPath = '@dro/attachment/views';

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

