# 快速上手

以 EIMS 中月结账单模型为例，演示一下配置过程，使得账单能支持上传扫描件附件。

## 1. Controller

```php
class BillingController extends Controller
{
    public function actions()
    {
        return [
            'image' => [
                'class' => 'dro\attachment\UploadAction',
                'modelClass' => 'backend\models\Billing',
                'uploadFormClass' => 'backend\models\UploadForm',
            ],
        ];
    }
}
```

## 2. Model
```php
// in Billing.php

public function getUploadViewParams($action)
{
    switch ($action) {
        case 'image':
            return [
                'label' => '月结账单扫描件',
                'subtitle' => $this->customer->full_name,
                'redirectRoute' => ['/billing/image', 'do' => 'manage', 'id' => $this->id],
                'navigationLinks' => [
                    $this->actionLink('upload-image', 'button', ['title' => '继续上传合同']),
                ],
                'dataProvider' => $this->getDataProvider('images'),
            ];
            break;
    }
}
```

## 3. UploadForm

```php
public function getUploadParams()
{
    switch ($this->scenario) {
        // ...
        case self::SCENARIO_BILLING_IMAGE:
            $attributes = [
                'type' => Media::TYPE_IMAGE,
                'category' => Media::CATEGORY_BILLING_IMAGE,
            ];
            $junctionModelClass = '\backend\models\BillingImage';
            $junctionAttribute = 'billing_id';
    }
}
```

至此，通过 `billing/image?do=create&id=xxx` 新建图片了。
