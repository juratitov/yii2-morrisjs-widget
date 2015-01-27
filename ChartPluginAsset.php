<?php
/**
 * @link https://github.com/juratitov/yii2-morrisjs-widget
 * @copyright Copyright (c) 2015
 * @license http://opensource.org/licenses/BSD-3-Clause
 */
namespace juratitov\morrisjs;

use yii\web\AssetBundle;

/**
 * ChartPluginAsset.php
 * 
 */
class ChartPluginAsset extends AssetBundle
{
	public $sourcePath = '@vendor/juratitov/yii2-morrisjs-widget/assets';

	public function init()
	{
		$this->js = YII_DEBUG ? ['js/morris.js'] : ['js/morris.min.js'];
		$this->css = ['css/morris.css'];
	}
}