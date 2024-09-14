# 快速上手
假设使用 YAT 创建了一个项目，里面有一个商品 Sku 模型，简要说明如何借助 Attachment 插件存储商品图片。

安装
----------------------------------------------------------------
### 引入插件
在项目 composer.json 内引入插件：

```
"require": {
    "drodata/yii2-attachment": "@dev",
}
```
执行 `composer update drodata/yii2-attachment`, 将项目下载至本地 vendors 目录.

### 新建表格 attachment
向数据库内新建表格 attachment:
```
./yii migrate --migrationPath=@dro/attachment/migrations
```

### 新建关联表格 sku_image

### 配置文件
在 `common/config/bootstrap.php` 内，指明文件存储的总目录路径:

```
Yii::setAlias('@static', dirname(__DIR__, 3) . '/eims/static/study');
```
### 模型
Attachmnent 模型后期可以考虑并入 yii2-attachment 内，需要改动的内容不多。
### 控制器
借助 Gii 在本地新建 Attachment 模型. 然后配置公用控制器：

```
// backend/config/main.php
return [
    ...
    'controllerMap' => [
        'attachment' => [
            'class' => 'dro\attachment\AttachmentController',
            'modelClass' => 'backend\models\Attachment',
        ],
        ...
    ],
];
```
部署
----------------------------------------------------------------

### SkuController

```php
class SkuController extends Controller
{
    public function actions()
    {
        return [
            'image' => [
                'class' => 'dro\attachment\UploadAction',
                'modelClass' => 'backend\models\Sku',
                'uploadFormClass' => 'backend\models\UploadForm',
            ],
        ];
    }
}
```

### Sku model

```php
// in Sku.php

public function getUploadViewParams($action)
{
    switch ($action) {
        case 'image':
            return [
                'label' => 'Sku image',
                'subtitle' => $this->name, 
                'redirectRoute' => ['/sku/image', 'do' => 'manage', 'id' => $this->id],
                'navigationLinks' => [
                    $this->actionLink('upload-image', 'button', ['title' => 'Add another one']),
                ],
                'dataProvider' => $this->getDataProvider('image'),
            ];
            break;
    }
}
```

### UploadForm
此文件需手动在项目内创建，格式大致如下：

```php
// in UploadForm.php
public function getUploadParams()
{
    switch ($this->scenario) {
        // ...
        case self::SCENARIO_SKU_IMAGE:
            $attributes = [
                'format' => Attachment::FORMAT_IMG,
                'category' => Attachment::CATEGORY_QUESTION_IMAGE,
            ];
            $junctionModelClass = '\backend\models\SkuImage';
            $junctionAttribute = 'sku_id';
    }
}
```

至此，通过 `sku/image?do=create&id=xxx` 即可新建图片。
