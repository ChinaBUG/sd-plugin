# SD-Plugin - Yii2 ActiveForm 扩展

一个为 Yii2 ActiveForm 添加 hint 提示和智能 placeholder 功能的轻量级扩展包。

## 特性

- 🎯 **智能 Placeholder** - 自动从模型标签生成 placeholder 文本
- 💡 **Hint 提示** - 灵活的表单字段提示功能
- 🎨 **高度可定制** - 支持自定义样式和位置
- 🔧 **最小侵入** - 与现有代码完全兼容
- ⚡ **简单易用** - 链式调用，集成简单

## 安装

通过 Composer 安装：

```bash
composer require your-vendor/sd-plugin
使用方法
方式1：使用扩展的 ActiveForm（推荐）
php
use sdplugin\ActiveForm;

$form = ActiveForm::begin();

echo $form->field($model, 'username')
    ->textInput()
    ->placeholder()  // 自动生成：请输入用户名
    ->hint('用户名长度为3-20个字符');

echo $form->field($model, 'email')
    ->textInput()
    ->placeholder('请输入您的电子邮箱')  // 自定义 placeholder
    ->hint('请填写有效的邮箱地址')
    ->hintPosition('before');  // 提示显示在输入框前

ActiveForm::end();
方式2：在原有 ActiveForm 中使用
php
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
    'fieldConfig' => [
        'class' => \sdplugin\ActiveField::className()
    ]
]);

echo $form->field($model, 'phone')
    ->textInput()
    ->placeholder()
    ->hint('请填写有效的手机号码');

ActiveForm::end();
API 参考
hint($content, $options = [])
设置字段提示内容。

参数：

$content: 提示内容字符串或配置数组

$options: 提示标签的 HTML 属性

示例：

php
->hint('这是提示内容')

->hint('自定义样式提示', [
    'class' => 'text-muted small',
    'tag' => 'small'
])

->hint([
    'content' => '通过数组配置',
    'class' => 'custom-hint'
])
hintPosition($position)
设置提示位置。

参数：

$position: 'before'（输入框前）或 'after'（输入框后，默认）

示例：

php
->hintPosition('before')
placeholder($text = null)
设置输入框 placeholder 文本。

参数：

$text: placeholder 文本，如果为 null 则自动从模型标签生成

示例：

php
->placeholder()  // 自动生成，如：请输入用户名
->placeholder('自定义placeholder文本')
模型标签配置
为了获得最佳的自动 placeholder 生成效果，建议在模型中定义属性标签：

php
class User extends \yii\db\ActiveRecord
{
    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'email' => '电子邮箱',
            'phone' => '手机号码',
            'birth_date' => '出生日期',
        ];
    }
}
使用上述配置时，->placeholder() 会自动生成：

"请输入用户名"（对于 username 字段）

"请输入电子邮箱"（对于 email 字段）

如果未定义模型标签，系统会从属性名自动生成：

first_name → "请输入First Name"

home_address → "请输入Home Address"

高级用法
组合使用多个功能
php
echo $form->field($model, 'description')
    ->textarea(['rows' => 4])
    ->placeholder('请简要描述您的情况')
    ->hint('最多500个字符', ['class' => 'text-warning'])
    ->hintPosition('before');
密码字段示例
php
echo $form->field($model, 'password')
    ->passwordInput()
    ->placeholder()
    ->hint('密码长度至少8位，包含字母和数字');
下拉选择框
php
echo $form->field($model, 'country')
    ->dropDownList($countries)
    ->hint('请选择您所在的国家');
常见问题
1. 类找不到错误
确保执行了 Composer 自动加载：

bash
composer dump-autoload
2. 提示不显示
检查是否正确引入了 sdplugin\ActiveForm 或在配置中指定了 sdplugin\ActiveField。

3. 自定义提示样式
通过 hint() 方法的第二个参数自定义 CSS 类：

php
->hint('提示内容', ['class' => 'your-custom-class'])
许可证
MIT

text

## 使用示例文件

### examples/usage-example.php
```php
<?php
/**
 * SD-Plugin 使用示例
 */

// 方式1：使用扩展的 ActiveForm
use sdplugin\ActiveForm;

$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]);

echo $form->field($model, 'username', [
    'inputOptions' => ['class' => 'form-control']
])->textInput()->placeholder()->hint('用户名长度为3-20个字符');

echo $form->field($model, 'email')->textInput()
    ->placeholder('your.email@example.com')
    ->hint('请填写有效的邮箱地址，用于接收验证邮件');

echo $form->field($model, 'password')->passwordInput()
    ->placeholder()
    ->hint('密码必须包含字母和数字，长度至少8位')
    ->hintPosition('before');

echo $form->field($model, 'bio')->textarea(['rows' => 4])
    ->placeholder('请简要介绍一下你自己...')
    ->hint([
        'content' => '这段描述将显示在个人资料中',
        'class' => 'text-muted small',
        'tag' => 'small'
    ]);

ActiveForm::end();

// 方式2：在现有项目中使用
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
    'fieldConfig' => [
        'class' => \sdplugin\ActiveField::className()
    ]
]);

echo $form->field($model, 'phone')->textInput()
    ->placeholder()
    ->hint('请填写有效的手机号码');

ActiveForm::end();