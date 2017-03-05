<?php

/**
 * Yii2 theme yii
 *
 * @link        http://www.brainbook.cc
 * @see         https://github.com/yongtiger/yii2-theme-yii2
 * @author      Tiger Yong <tigeryang.brainbook@outlook.com>
 * @copyright   Copyright (c) 2017 BrainBook.CC
 * @license     http://opensource.org/licenses/MIT
 */

namespace yongtiger\themeyii;

use Yii;

/**
 * Application asset bundle.
 *
 * @package yongtiger\themeyii
 */
class ThemeAsset extends \yongtiger\assetbundle\AssetBundle
{
    // static $themePath = '@yongtiger/themeyii2'; ///optional
    // static $themeUrlReplace = '{theme}';    ///optional

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
