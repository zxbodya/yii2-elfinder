<?php

namespace zxbodya\yii2\elfinder;

use Yii;
use yii\web\AssetBundle;

/**
 * This is just an example.
 */
class ElFinderAsset extends AssetBundle
{
    public $sourcePath = '@zxbodya/yii2/elfinder/assets';
    public $js = [
        'js/elfinder.full.js',
//        'js/elfinder.min.js',
    ];
    public $css = [
        'css/elfinder.css'
    ];
    public $depends = [
        'yii\jui\JuiAsset',
    ];

    public function init()
    {
        // elFinder translation
        $langs = [
            'bg',
            'jp',
            'sk',
            'cs',
            'ko',
            'th',
            'de',
            'lv',
            'tr',
            'el',
            'nl',
            'uk',
            'es',
            'no',
            'vi',
            'fr',
            'pl',
            'zh_CN',
            'hr',
            'pt_BR',
            'zh_TW',
            'hu',
            'ro',
            'it',
            'ru'
        ];
        $lang = Yii::$app->language;
        if (!in_array($lang, $langs)) {
            if (strpos($lang, '_')) {
                $lang = substr($lang, 0, strpos($lang, '_'));
                if (!in_array($lang, $langs)) {
                    $lang = false;
                }
            } else {
                $lang = false;
            }
        }
        if ($lang !== false) {
            $this->js[] = 'js/i18n/elfinder.' . $lang . '.js';
        }

        parent::init();
    }

}