<?php

namespace sdplugin;

use yii\helpers\Html;
use yii\helpers\Inflector;

/**
 * Extended ActiveField with hint and placeholder functionality
 */
class ActiveField extends \yii\bootstrap\ActiveField
{
    /**
     * @var string|array the hint content
     */
    public $hint;
    
    /**
     * @var array the options for the hint tag
     */
    public $hintOptions = [];
    
    /**
     * @var string the position of hint relative to input ('before', 'after')
     */
    public $hintPosition = 'after';
    
    /**
     * Sets the hint content and options
     * 
     * @param string|array $content the hint content. If an array, it will be treated as the options for the hint tag,
     * and the actual hint content will be determined by the 'content' key.
     * @param array $options the options for the hint tag
     * @return $this
     */
    public function hint($content, $options = [])
    {
        if (is_array($content)) {
            $options = $content;
            $content = isset($options['content']) ? $options['content'] : null;
            unset($options['content']);
        }
        
        $this->hint = $content;
        $this->hintOptions = array_merge($this->hintOptions, $options);
        
        return $this;
    }
    
    /**
     * Sets the hint position
     * 
     * @param string $position the position ('before', 'after')
     * @return $this
     */
    public function hintPosition($position)
    {
        $this->hintPosition = $position;
        return $this;
    }
    
    /**
     * Sets the placeholder text
     * 
     * @param string|null $text the placeholder text. If null, will generate from model attribute label
     * @return $this
     */
    public function placeholder($text = null)
    {
        if ($text === null) {
            $text = $this->generatePlaceholder();
        }
        
        // 直接设置到 inputOptions 中
        if (!isset($this->inputOptions)) {
            $this->inputOptions = [];
        }
        
        $this->inputOptions['placeholder'] = $text;
        
        return $this;
    }
    
    /**
     * Generates placeholder text from model attribute
     * 
     * @return string the generated placeholder text
     */
    protected function generatePlaceholder()
    {
        $model = $this->model;
        $attribute = $this->attribute;
        
        // 首先尝试从模型的 attributeLabels() 获取标签
        $labels = $model->attributeLabels();
        if (isset($labels[$attribute])) {
            return "请输入" . $labels[$attribute];
        }
        
        // 如果没有定义标签，从属性名生成
        return "请输入" . Inflector::camel2words($attribute, true);
    }
    
    /**
     * {@inheritdoc}
     */
    public function render($content = null)
    {
        if ($content === null) {
            $this->addHintToTemplate();
        }
        
        return parent::render($content);
    }
    
    /**
     * Adds hint to the field template
     */
    protected function addHintToTemplate()
    {
        if ($this->hint === null) {
            return;
        }
        
        $hintContent = $this->renderHint();
        
        if ($this->hintPosition === 'before') {
            $this->template = str_replace('{input}', $hintContent . '{input}', $this->template);
        } else {
            $this->template = str_replace('{input}', '{input}' . $hintContent, $this->template);
        }
    }
    
    /**
     * Renders the hint content
     * 
     * @return string the rendered hint
     */
    protected function renderHint()
    {
        $options = $this->hintOptions;
        $tag = isset($options['tag']) ? $options['tag'] : 'div';
        unset($options['tag']);
        
        Html::addCssClass($options, isset($options['class']) ? $options['class'] : 'help-block');
        
        $content = $this->hint;
        if (is_array($content)) {
            $content = isset($content['content']) ? $content['content'] : '';
        }
        
        return Html::tag($tag, $content, $options);
    }
}