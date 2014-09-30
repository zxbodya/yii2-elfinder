<?php
namespace zxbodya\yii2\elfinder;

use Yii;
use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\AssetBundle;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\InputWidget;
use zxbodya\yii2\elfinder\ElFinderAsset;

class ElFinderInput extends InputWidget
{
    /**
     * Client settings.
     * More about this: https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
     * @var array
     */
    public $settings = array();
    public $connectorRoute = false;

    public function init()
    {

        if (empty($this->connectorRoute)) {
            throw new Exception('$connectorRoute must be set!');
        }
        $this->settings['url'] = Url::toRoute($this->connectorRoute);
        $this->settings['lang'] = Yii::$app->language;
    }

    public function run()
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }

        $contoptions = $this->options;
        $contoptions['id'] = $this->options['id'] . 'container';
        echo Html::beginTag('div', $contoptions);
        $inputOptions = array('id' => $this->options['id'], 'style' => 'float:left;' /*, 'readonly' => 'readonly'*/);
        if ($this->hasModel()) {
            echo Html::activeTextInput($this->model, $this->attribute, $inputOptions);
        } else {
            echo Html::textInput($this->name, $this->value, $inputOptions);
        }

        echo Html::button('Browse', array('id' => $this->options['id'] . 'browse', 'class' => 'btn'));
        echo Html::endTag('div');

        $settings = array_merge(
            array(
                'places' => "",
                'rememberLastDir' => false,
            ),
            $this->settings
        );

        $settings['dialog'] = array(
            'zIndex' => 400001,
            'width' => 900,
            'modal' => true,
            'title' => "Files",
        );
        $settings['editorCallback'] = new JsExpression('function(url) {$(\'#\'+aFieldId).attr(\'value\',url);}');
        $settings['closeOnEditorCallback'] = true;
        $connectorUrl = Json::encode($this->settings['url']);
        $settings = Json::encode($settings);
        $script = <<<EOD
        window.elfinderBrowse = function(field_id, connector) {
            var aFieldId = field_id, aWin = this;
            if($("#elFinderBrowser").length == 0) {
                $("body").append($("<div/>").attr("id", "elFinderBrowser"));
                var settings = $settings;
                settings["url"] = connector;
                $("#elFinderBrowser").elfinder(settings);
            }
            else {
                $("#elFinderBrowser").elfinder("open", connector);
            }
        }
EOD;

        $view = $this->getView();
        ElFinderAsset::register($view);
        $view->registerJs($script, View::POS_READY, $key = 'ServerFileInput#global');

        $js = //'$("#'.$id.'").focus(function(){window.elfinderBrowse("'.$name.'")});'.
            '$("#' . $this->options['id'] . 'browse")'
            . '.click(function(){window.elfinderBrowse("' . $this->options['id'] . '", ' . $connectorUrl . ')});';


        $view->registerJs($js);
    }

}
