<?php
namespace zxbodya\yii2\elfinder;

use Yii;
use yii\base\Exception;
use yii\base\Widget;
use yii\helpers\Json;
use yii\helpers\Url;

class ElFinderWidget extends Widget
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
        $lang = Yii::$app->language;

        if (strpos($lang, '-')) {
            $lang = substr($lang, 0, strpos($lang, '-'));
        }

        $this->settings['lang'] = $lang;
    }

    public function run()
    {
        $id = $this->getId();
        $settings = Json::encode($this->settings);
        $view = $this->getView();
        ElFinderAsset::register($view);
        $view->registerJs("$('#$id').elfinder($settings);");
        echo "<div id=\"$id\"></div>";
    }

}
