<?php

namespace sdplugin\assets;

use yii\web\AssetBundle;

/**
 * SD-Plugin asset bundle
 */
class SdPluginAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/css';
    
    public $css = [
        'sd-plugin.css',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}