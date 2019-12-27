# yii2-easy-wechat

微信 SDK for yii2， 基于 [overtrue/wechat](https://github.com/overtrue/wechat)

## 要求

- php: ^7.2
- yiisoft/yii2: ~2.0.14
- overtrue/wechat: ~4.0

## 安装

```shell
composer require "demokn/yii2-easy-wechat:~1.0"
```

## 配置

```php
'components' => [
    // ...
    // 注册组件
    'wechat' => [
        'class' => \demokn\easywechat\Wechat::class,
        // 自定义服务模块, 详见: https://www.easywechat.com/docs/master/customize/replace-service
        'rebinds' => [
            'cache' => function () {
                $cache = new \Symfony\Component\Cache\Psr16Cache(new \Symfony\Component\Cache\Adapter\FilesystemAdapter());
            
                return $cache;
            },
        ],
        // EasyWechat 配置, 每个模块都支持多账号, 默认为 `default`
        // 参考: 
        'easyWechatConfig' => [
            // 默认配置，将会合并到各模块中
            'defaults' => [
                'response_type' => 'array',
            ],
            // 公众号
            'official_account' => [
                'default' => [
                    'app_id' => '',
                    'secret' => '',
                    'token' => '',
                    'aes_key' => '',
                ],
                'another' => [
                    'app_id' => '',
                    'secret' => '',
                    'token' => '',
                    'aes_key' => '',
                ],
            ],
            // 小程序
            'mini_program' => [
                'default' => [
                    'app_id' => '',
                    'secret' => '',
                    'token' => '',
                    'aes_key' => '',
                ],
            ],
            // 微信支付
            'payment' => [
                'default' => [
                    'sandbox' => true,
                    'app_id' => '',
                    'mch_id' => '',
                    'key' => '',
                    'cert_path' => '',
                    'key_path' => '',
                    'notify_url' => '',
                ],
            ],
            // 企业微信
            'work' => [
                'default' => [
                    'corp_id' => '',
                    'agent_id' => '',
                    'secret' => '',
                ],
            ],
            // 开放平台第三方平台
            'open_platform' => [
                'default' => [
                    'app_id' => '',
                    'secret' => '',
                    'token' => '',
                    'aes_key' => '',
                ],
            ],
            // 企业微信开放平台
            'open_work' => [
                'default' => [
                    'corp_id' => '服务商的corpid',
                    'secret' => '服务商的secret，在服务商管理后台可见',
                    'suite_id' => '以ww或wx开头应用id',
                    'suite_secret' => '应用secret',
                    'token' => '应用的Token',
                    'aes_key' => '应用的EncodingAESKey',
                    'reg_template_id' => '注册定制化模板ID',
                    'redirect_uri_install' => '安装应用的回调url（可选）',
                    'redirect_uri_single' => '单点登录回调url （可选）',
                    'redirect_uri_oauth' => '网页授权第三方回调url （可选）',
                ],
            ],
        ],
    ],
    // ...
],
```

## 使用

```php
// 获取微信公众号默认实例
$app = Yii::$app->wechat->officialAccount();

// 获取微信小程序默认实例
$app = Yii::$app->wechat->miniProgram();

// 获取微信支付默认实例
$app = Yii::$app->wechat->payment();

// 获取企业微信默认实例
$app = Yii::$app->wechat->work();

// 获取微信开放平台第三方平台默认实例
$app = Yii::$app->wechat->openPlatform();

// 获取企业微信开放平台默认实例
$app = Yii::$app->wechat->openWork();

// 获取微信公众号指定实例
$app = Yii::$app->wechat->officialAccount('another');

// 获取其他模块指定实例
// ...
```

更多 SDK 的具体使用请参考 [EasyWechat Docs](https://www.easywechat.com/docs)

## License

MIT
