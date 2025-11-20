<?php

namespace sdplugin;

/**
 * Extended ActiveForm that uses our custom ActiveField
 */
class ActiveForm extends \yii\bootstrap\ActiveForm
{
    /**
     * {@inheritdoc}
     */
    public function field($model, $attribute, $options = [])
    {
        // 确保使用我们的 ActiveField
        if (!isset($options['class'])) {
            $options['class'] = ActiveField::className();
        }
        
        return parent::field($model, $attribute, $options);
    }
}