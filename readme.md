ElFinder 1.x Yii extension
==========================

0. Checkout source code to your project, for example to ext.elFinder
1. Create controller for connector action, and configure it params

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
                              'root' => Yii::getAlias('web') . '/uploads/',                    
                              'URL' => Yii::$app->request->baseUrl . '/uploads/',         
                              'rootAlias' => 'Home',         
                              'mimeDetect' => 'none'         
                          )                    
                      ),         
                  ];                    
              }         
          }        
                
        

2. ServerFileInput - use this widget to choose file on server using ElFinder pop-up

          echo $form->field($model, 'filePath')->widget(
              ServerFileInput::className(),
              ['connectorRoute' => 'el-finder/connector',]
          )
3. ElFinderWidget use this widget to manage files

          echo ElFinderWidget::widget(
              ['connectorRoute' => 'el-finder/connector',]
          )
          
4. To use TinyMceElFinder see: https://bitbucket.org/z_bodya/yii-tinymce