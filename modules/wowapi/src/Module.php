<?php
namespace modules\wowapi;

use Craft;
use yii\base\Module as BaseModule;

class Module extends BaseModule
{
    public static function getInstance(): self
    {
        return parent::getInstance(self::class);
    }

    public function init()
    {
        parent::init();

        // register our service component
        $this->setComponents([
            'apiService' => \modules\wowapi\services\ApiService::class,
        ]);

        Craft::info('WowApi module loaded', __METHOD__);
    }
}
