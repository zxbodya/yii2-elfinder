<?php
namespace zxbodya\yii2\elfinder;

use yii\base\Action;

class ConnectorAction extends Action
{
    /**
     * @var array
     */
    public $settings = array();

    public function run()
    {
        require_once(dirname(__FILE__) . '/php/elFinder.class.php');
        $fm = new \elFinder($this->settings);
        $fm->run();
    }

}
