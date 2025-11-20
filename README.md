# SD-Plugin - Yii2 ActiveForm Extension

为 Yii2 ActiveForm 添加 hint 提示和智能 placeholder 功能。

## 安装

```bash
composer require sdev/sd-plugin

基本使用
php
use sdplugin\ActiveForm;


使用示例
php
use sdplugin\ActiveForm;

$form = ActiveForm::begin();

// label-after：hint 显示在 label 标签内部
echo $form->field($model, 'username')
    ->textInput()
    ->hint('用户名长度为3-20个字符')
    ->hintPosition('label-after')
    ->hintMode('icon');

// 单行模式在 label 后
echo $form->field($model, 'email')
    ->textInput()
    ->hint('必填字段')
    ->hintPosition('label-after')
    ->hintMode('inline');

// 不显示图标
echo $form->field($model, 'phone')
    ->textInput()
    ->hint('选填')
    ->hintPosition('label-after')
    ->hintMode('inline')
    ->showIcon(false);

ActiveForm::end();


$form = ActiveForm::begin();

// 标签后图标提示
echo $form->field($model, 'username')
    ->textInput()
    ->hint('用户名提示')
    ->hintPosition('label-after');

// 输入框前单行提示
echo $form->field($model, 'email')
    ->textInput()
    ->hint('邮箱提示')
    ->hintMode('inline')
    ->hintPosition('input-before');

// 输入框后图标提示（默认）
echo $form->field($model, 'phone')
    ->textInput()
    ->hint('手机号提示');

ActiveForm::end();
提示位置
标签后 (label-after)
php
->hintPosition('label-after')
提示显示在标签文字后面

输入框前 (input-before)
php
->hintPosition('input-before')
提示显示在输入框前面

输入框后 (input-after) - 默认
php
->hintPosition('input-after')
提示显示在输入框后面

提示模式
图标模式（默认）
鼠标悬停显示提示

php
->hint('提示内容')
->hintMode('icon')
单行模式
直接显示提示文字

php
->hint('提示内容')
->hintMode('inline')
图标控制
php
// 显示图标（默认）
->showIcon(true)

// 不显示图标
->showIcon(false)
智能 Placeholder
php
// 自动生成
->placeholder()

// 自定义
->placeholder('自定义提示')


手动加载资源（可选）
如果需要手动控制资源加载：

php
use sdplugin\assets\SdPluginAsset;

// 手动注册资源
SdPluginAsset::register($this);


完整示例
php
echo $form->field($model, 'username')
    ->textInput()
    ->placeholder()
    ->hint('3-20个字符')
    ->hintPosition('label-after');

echo $form->field($model, 'password')
    ->passwordInput()
    ->hint('至少8位字符')
    ->hintMode('inline')
    ->hintPosition('input-before')
    ->showIcon(false);

echo $form->field($model, 'email')
    ->textInput()
    ->hint('用于接收验证邮件')
    ->hintPosition('input-after');

echo $form->field($model, 'bio')
    ->textarea()
    ->hint('简单自我介绍')
    ->hintMode('inline')
    ->hintPosition('label-after');