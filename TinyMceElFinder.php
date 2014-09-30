<?php
namespace zxbodya\yii2\elfinder;

use Yii;
use yii\base\Exception;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;
use zxbodya\yii2\tinymce\FileManager;

class TinyMceElFinder extends FileManager
{
    private $_id;
    private static $_counter = 0;

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


    public function getId()
    {
        if ($this->_id !== null) {
            return $this->_id;
        } else {
            return $this->_id = 'elfd' . self::$_counter++;
        }
    }

    /**
     * @return string
     */
    public function getFileBrowserCallback()
    {
        $connectorUrl = $this->settings['url'];
        $id = $this->getId();
        $settings = array_merge(
            array(
                'places' => "",
                'rememberLastDir' => false,
            ),
            $this->settings
        );

        $settings['dialog'] = array(
            'width' => 900,
            'modal' => true,
            'title' => "Files",
        );
        $settings['editorCallback'] = new JsExpression(
            <<<JS
            function(url) {
                aWin.document.getElementById(field_name).value = url;
                if (type == "image" && aFieldName=="src" && aWin.ImageDialog.showPreviewImage)
                    aWin.ImageDialog.showPreviewImage(url);
            }
JS
        );
        $settings['closeOnEditorCallback'] = true;

        $settings = Json::encode($settings);

        $script = <<<JS
        function(field_name, url, type, win) {
            var aFieldName = field_name, aWin = win;
            var el = $("#$id");
            if(el.length == 0) {
                el = $("<div/>").attr("id", "$id");
                $("body").append(el);
                el.elfinder($settings);
                //place it above tinymce dialogue
                el[0].elfinder.dialog.closest('.ui-dialog').css({'z-index':4000001});
            }
            else {
                el.elfinder("open","$connectorUrl");
            }
        }
JS;

        return new JsExpression($script);
    }

    /**
     * @param View $view
     */
    public function registerAsset($view)
    {
        ElFinderAsset::register($view);
    }
}
