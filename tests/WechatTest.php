<?php

namespace demokn\easywechat\tests;

use demokn\easywechat\Wechat;
use EasyWeChat\MiniProgram\Application as MiniProgram;
use EasyWeChat\OfficialAccount\Application as OfficialAccount;
use EasyWeChat\OpenPlatform\Application as OpenPlatform;
use EasyWeChat\OpenWork\Application as OpenWork;
use EasyWeChat\Payment\Application as Payment;
use EasyWeChat\Work\Application as Work;

class WechatTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->mockApplication([
            'components' => [
                'wechat' => [
                    'class' => Wechat::class,
                    'easyWechatConfig' => [
                        'defaults' => [
                            'response_type' => 'array',
                        ],
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
                        'mini_program' => [
                            'default' => [
                                'app_id' => '',
                                'secret' => '',
                                'token' => '',
                                'aes_key' => '',
                            ],
                        ],
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
                        'work' => [
                            'default' => [
                                'corp_id' => '',
                                'agent_id' => '',
                                'secret' => '',
                            ],
                        ],
                        'open_platform' => [
                            'default' => [
                                'app_id' => '',
                                'secret' => '',
                                'token' => '',
                                'aes_key' => '',
                            ],
                        ],
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
            ],
        ]);
    }

    /**
     * @return Wechat
     */
    protected function getWechatComponent()
    {
        return \Yii::$app->wechat;
    }

    public function testInstanceWechatComponent()
    {
        $this->assertInstanceOf(Wechat::class, $this->getWechatComponent());
    }

    public function testGetOfficialAccount()
    {
        $officialAccount = $this->getWechatComponent()->officialAccount();
        $this->assertInstanceOf(OfficialAccount::class, $officialAccount);
        $anotherOfficialAccount = $this->getWechatComponent()->officialAccount('another');
        $this->assertInstanceOf(OfficialAccount::class, $anotherOfficialAccount);
    }

    public function testGetMiniProgram()
    {
        $miniProgram = $this->getWechatComponent()->miniProgram();
        $this->assertInstanceOf(MiniProgram::class, $miniProgram);
    }

    public function testGetPayment()
    {
        $payment = $this->getWechatComponent()->payment();
        $this->assertInstanceOf(Payment::class, $payment);
    }

    public function testGetWork()
    {
        $work = $this->getWechatComponent()->work();
        $this->assertInstanceOf(Work::class, $work);
    }

    public function testGetOpenPlatform()
    {
        $work = $this->getWechatComponent()->openPlatform();
        $this->assertInstanceOf(OpenPlatform::class, $work);
    }

    public function testGetOpenWork()
    {
        $work = $this->getWechatComponent()->openWork();
        $this->assertInstanceOf(OpenWork::class, $work);
    }
}
