<?php

namespace sdplugin;

use yii\helpers\Html;
use yii\helpers\Inflector;
use sdplugin\assets\SdPluginAsset;

/**
 * Extended ActiveField with hint and placeholder functionality
 */
class ActiveField extends \yii\bootstrap\ActiveField
{
    public $hint;
    public $hintOptions = [];
    public $hintPosition = 'input-before'; // 改为 input-before
    public $hintMode = 'inline'; // 改为 inline
    public $showIcon = true;
    private $_placeholder;
    
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        SdPluginAsset::register($this->form->getView());
    }
    
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
    
    public function hintPosition($position)
    {
        $this->hintPosition = $position;
        return $this;
    }
    
    public function hintMode($mode)
    {
        $this->hintMode = $mode;
        return $this;
    }
    
    public function showIcon($show)
    {
        $this->showIcon = $show;
        return $this;
    }
    
    public function placeholder($text = null)
    {
        if ($text === null) {
            $text = $this->generatePlaceholder();
        }
        
        $this->_placeholder = $text;
        
        return $this;
    }
    
    protected function generatePlaceholder()
    {
        $model = $this->model;
        $attribute = $this->attribute;
        
        $labels = $model->attributeLabels();
        if (isset($labels[$attribute])) {
            return "请输入" . $labels[$attribute];
        }
        
        return "请输入" . Inflector::camel2words($attribute, true);
    }
    
    /**
     * {@inheritdoc}
     */
    public function textInput($options = [])
    {
        if ($this->_placeholder !== null) {
            $options['placeholder'] = $this->_placeholder;
        }
        
        return parent::textInput($options);
    }
    
    /**
     * {@inheritdoc}
     */
    public function passwordInput($options = [])
    {
        if ($this->_placeholder !== null) {
            $options['placeholder'] = $this->_placeholder;
        }
        
        return parent::passwordInput($options);
    }
    
    /**
     * {@inheritdoc}
     */
    public function textarea($options = [])
    {
        if ($this->_placeholder !== null) {
            $options['placeholder'] = $this->_placeholder;
        }
        
        return parent::textarea($options);
    }
    
    /**
     * {@inheritdoc}
     */
    public function input($type, $options = [])
    {
        if ($this->_placeholder !== null) {
            $options['placeholder'] = $this->_placeholder;
        }
        
        return parent::input($type, $options);
    }
    
    public function render($content = null)
    {
        if ($content === null) {
            $this->addHintToTemplate();
        }
        
        return parent::render($content);
    }
    
    protected function addHintToTemplate()
    {
        if ($this->hint === null) {
            return;
        }
        
        $hintContent = $this->renderHint();
        
        switch ($this->hintPosition) {
            case 'label-after':
                $this->template = preg_replace('/(\{label\})/', '$1' . $hintContent, $this->template);
                break;
            case 'input-before':
                $this->template = str_replace('{input}', $hintContent . '{input}', $this->template);
                break;
            case 'input-after':
            default:
                $this->template = str_replace('{input}', '{input}' . $hintContent, $this->template);
                break;
        }
    }
    
    protected function renderHint()
    {
        if ($this->hintMode === 'inline') {
            return $this->renderInlineHint();
        }
        
        return $this->renderIconHint();
    }
    
    protected function renderInlineHint()
    {
        $options = $this->hintOptions;
        $tag = isset($options['tag']) ? $options['tag'] : 'span';
        unset($options['tag']);
        
        Html::addCssClass($options, 'hint-inline');
        
        $content = $this->hint;
        if (is_array($content)) {
            $content = isset($content['content']) ? $content['content'] : '';
        }
        
        if ($this->showIcon) {
            $content = '<i class="hint-icon">!</i> ' . $content;
        }
        
        return Html::tag($tag, $content, $options);
    }
    
    protected function renderIconHint()
    {
        $options = $this->hintOptions;
        $tag = isset($options['tag']) ? $options['tag'] : 'span';
        unset($options['tag']);
        
        Html::addCssClass($options, 'hint-icon-wrapper');
        
        $content = $this->hint;
        if (is_array($content)) {
            $content = isset($content['content']) ? $content['content'] : '';
        }
        
        $iconHtml = '<i class="hint-icon">!</i>';
        $tooltipHtml = '<span class="hint-tooltip">' . $content . '</span>';
        
        return Html::tag($tag, $iconHtml . $tooltipHtml, $options);
    }
}