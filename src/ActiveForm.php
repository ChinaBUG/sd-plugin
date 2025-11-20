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
        if (!isset($options['class'])) {
            $options['class'] = ActiveField::className();
        }
        
        return parent::field($model, $attribute, $options);
    }
}