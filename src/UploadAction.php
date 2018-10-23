<?php

namespace dro\attachment;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

class UploadAction extends \yii\base\Action
{
    public $uploadFormClass;
    public $modelClass;

    public $viewPath = '@dro/attachment/views';

    protected $scenario;
    /**
     * @var bool 是否在上传页面内显示已上传附件 list
     *
     */
    public $showUploadedList = true;

    public function init()
    {
        parent::init();
        // 约定 UploadForm scenario 和 MediaType 都使用如下格式命名
        $this->scenario = $this->controller->id . '-' . $this->id;
    }

    /**
     * $do: 'manage', 'create'
     */
    public function run($id, $do)
    {

        $formClass = $this->uploadFormClass;
        $model = new $formClass([
            'scenario' => $this->scenario,
            'key' => $id,
        ]);
        $params = $this->getViewParams();
        $redirectRoute = ArrayHelper::getValue($params, 'redirectRoute');
        $label = ArrayHelper::getValue($params, 'label');

        if ($do == 'create' && Yii::$app->request->isPost) {
            $model->files = UploadedFile::getInstances($model, 'files');

            if ($model->upload()) {
                Yii::$app->session->setFlash('success', $label . '已上传');
                return $this->controller->redirect($redirectRoute);
            }
        }

        $view = "{$this->viewPath}/{$do}";
        return $this->controller->render($view, ArrayHelper::merge($this->getViewParams(), ['model' => $model]));
    }

    protected function getViewParams()
    {
        $modelClass = $this->modelClass;

        $model = $modelClass::findOne(Yii::$app->request->get('id'));

        return $model->getUploadViewParams($this->id);
    }
}
