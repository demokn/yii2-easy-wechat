<?php

namespace demokn\easywechat;

use EasyWeChat\Kernel\ServiceContainer;
use EasyWeChat\MiniProgram\Application as MiniProgram;
use EasyWeChat\OfficialAccount\Application as OfficialAccount;
use EasyWeChat\OpenPlatform\Application as OpenPlatform;
use EasyWeChat\OpenWork\Application as OpenWork;
use EasyWeChat\Payment\Application as Payment;
use EasyWeChat\Work\Application as Work;
use Yii;
use yii\base\Component;
use yii\base\Exception;

class Wechat extends Component
{
    /**
     * @var array
     */
    public $rebinds;

    /**
     * @var array
     */
    public $easyWechatConfig;

    /**
     * @var array
     */
    protected $easyWechatApplications = [];

    public function init(): void
    {
        parent::init();

        $apps = [
            'official_account' => OfficialAccount::class,
            'work' => Work::class,
            'mini_program' => MiniProgram::class,
            'payment' => Payment::class,
            'open_platform' => OpenPlatform::class,
            'open_work' => OpenWork::class,
        ];

        $defaults = $this->easyWechatConfig['defaults'] ?? [];
        foreach ($apps as $type => $class) {
            $accounts = $this->easyWechatConfig[$type] ?? [];
            foreach ($accounts as $account => $config) {
                $this->easyWechatApplications[$type][$account] = function () use ($type, $class, $config, $defaults) {
                    $app = new $class(array_merge($defaults, $config));
                    $this->rebindServices($app);

                    return $app;
                };
            }
        }
    }

    protected function rebindServices(ServiceContainer $app): void
    {
        if (null === $this->rebinds) {
            return;
        }

        foreach ($this->rebinds as $name => $service) {
            if (is_string($service) && class_exists($service)) {
                $service = new $service(Yii::$app);
            } elseif (is_callable($service)) {
                $service = call_user_func($service, Yii::$app);
            }

            $app->rebind($name, $service);
        }
    }

    protected function resolveEasyWechatApplication(string $type, string $account): ServiceContainer
    {
        if (!isset($this->easyWechatApplications[$type]) || !isset($this->easyWechatApplications[$type][$account])) {
            throw new Exception("Unknown account {$type}.{$account}");
        }

        $app = $this->easyWechatApplications[$type][$account];
        if ($app instanceof ServiceContainer) {
            return $app;
        }

        if (is_callable($app)) {
            $app = call_user_func($app);
            $this->easyWechatApplications[$type][$account] = $app;
        }

        return $app;
    }

    public function officialAccount($name = 'default'): OfficialAccount
    {
        return $this->resolveEasyWechatApplication('official_account', $name);
    }

    public function miniProgram($name = 'default'): MiniProgram
    {
        return $this->resolveEasyWechatApplication('mini_program', $name);
    }

    public function payment($name = 'default'): Payment
    {
        return $this->resolveEasyWechatApplication('payment', $name);
    }

    public function work($name = 'default'): Work
    {
        return $this->resolveEasyWechatApplication('work', $name);
    }

    public function openPlatform($name = 'default'): OpenPlatform
    {
        return $this->resolveEasyWechatApplication('open_platform', $name);
    }

    public function openWork($name = 'default'): OpenWork
    {
        return $this->resolveEasyWechatApplication('open_work', $name);
    }
}
