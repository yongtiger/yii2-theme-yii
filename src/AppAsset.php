<?php

namespace yongtiger\themeyii;

use Yii;

/**
 * Application asset bundle.
 */
class AppAsset extends \yongtiger\AssetBundle
{
    public $sourcePath = '@yongtiger/themeyii/assets';
    public $css = [
        'css/site.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
