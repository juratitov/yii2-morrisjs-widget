<?php

/**
 * @link https://github.com/juratitov/yii2-morrisjs-widget
 * @copyright Copyright (c) 2015 Jura
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace juratitov\morrisjs;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 *
 * Chart renders a Morris.JS plugin widget.
 *
 */
class Chart extends Widget
{

    /**
     * @var array the options for Morris.JS charts.
     */
    public $options = [];

    /**
     *
     * @var array the HTML options for div element
     */
    public $elementOptions = [
        'style' => 'height: 250px;'
    ];

    /**
     * @var string the type of chart to display. The possible options are:
     * - "Line" 
     * - "Bar" 
     * - "Area"
     * - "Donut"
     */
    public $type;

    const TYPE_LINE = 'Line';
    const TYPE_AREA = 'Area';
    const TYPE_BAR = 'Bar';
    const TYPE_DONUT = 'Donut';

    /**
     * Initializes the widget.
     * This method will register the bootstrap asset bundle. If you override this method,
     * make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();

        if ($this->type === null || !$this->validateType($this->type)) {
            throw new InvalidConfigException("The 'type' option is required or not valid");
        }

        if (!isset($this->options['element'])) {
            $this->options['element'] = $this->getId();
        } else {
            $this->elementOptions['id'] = $this->options['element'];
        }

        $this->validateRequiredOptions($this->type);
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo Html::tag('div', '', $this->elementOptions);
        $this->registerPlugin($this->type);
    }

    /**
     * 
     * @param type $name
     */
    protected function registerPlugin($name)
    {
        $view = $this->getView();
        ChartPluginAsset::register($view);

        $options = Json::encode($this->options);
        $js = "new Morris.$name($options)";
        
        $view->registerJs($js);
    }

    /**
     * Validate type
     * 
     * @param string $type
     * @return boolean
     */
    protected function validateType($type)
    {
        return in_array($type, [self::TYPE_LINE, self::TYPE_AREA, self::TYPE_BAR, self::TYPE_DONUT]);
    }

    /**
     * Validate options
     * 
     * @param type $type
     * @return type
     */
    protected function validateRequiredOptions($type)
    {
        if (!isset($this->options['data'])) {
            throw new InvalidConfigException("The 'data' option is required");
        }
        if (!$type === self::TYPE_DONUT) {
            if (!isset($this->options['xkey'])) {
                throw new InvalidConfigException("The 'xkey' option is required");
            }
            if (!isset($this->options['ykeys'])) {
                throw new InvalidConfigException("The 'ykeys' option is required");
            }
            if (!isset($this->options['labels'])) {
                throw new InvalidConfigException("The 'labels' option is required");
            }
        }
    }

}
