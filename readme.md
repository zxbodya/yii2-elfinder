# ElFinder 1.x Yii2 extension

Extension to simplify adding elFinder to Yii2 project.

Extension is rework from Yii 1.1 extension:

[https://github.com/zxbodya/yii-elfinder](https://github.com/zxbodya/yii-elfinder)


##Installation
The preferred way to install this extension is through [composer](https://getcomposer.org/).

Either run

`php composer.phar require --prefer-dist zxbodya/yii2-elfinder "*@dev"`

or add

`"zxbodya/yii2-elfinder": "*@dev"`

to the require section of your `composer.json` file.

## Backend controller configuration

```php
namespace backend\controllers;         
use Yii;       
use yii\web\Controller;         
use zxbodya\yii2\elfinder\ConnectorAction; 
      
class ElFinderController extends Controller         
{         
    public function actions()         
    {         
        return [         
            'connector' => array(         
                'class' => ConnectorAction::className(),         
                'settings' => array(         
                    'root' => Yii::getAlias('@webroot') . '/uploads/',                    
                    'URL' => Yii::getAlias('@web') . '/uploads/',         
                    'rootAlias' => 'Home',         
                    'mimeDetect' => 'none'         
                )                    
            ),         
        ];                    
    }         
}
```
                
        
## Widgets usage

### FileInput
widget to choose file on server using ElFinder pop-up

```php
echo $form->field($model, 'filePath')->widget(
    ElFinderInput::className(),
    ['connectorRoute' => 'el-finder/connector',]
)
```
### ElFinderWidget

```php
echo ElFinderWidget::widget(
    ['connectorRoute' => 'el-finder/connector',]
)
```       

## TinyMce integration
Widgets supports intergation with TinyMce wysiwyg editor 
For more details see tinymce extension [https://github.com/zxbodya/yii2-tinymce](https://github.com/zxbodya/yii2-tinymce)