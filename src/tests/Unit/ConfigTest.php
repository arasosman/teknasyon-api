<?php

namespace Tests\Unit;

use App\Services\ConfigService;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    /** @var ConfigService */
    protected $configService;

    public function setUp(): void
    {
        $this->configService = app(ConfigService::class);
        parent::setUp();
    }

    /**
     * @test
     * @dataProvider configDataProvider
     */
    public function testConfigStatus($result, $config)
    {
        $currentConfig = [
            'app_ver' => "1.2",
            'lang_ver' => "1.4",
        ];
        $this->configService->setConfig($config);
        $this->configService->setCurrentConfig($currentConfig);

        $this->assertEquals($result, $this->configService->checkVersion());
    }

    public function configDataProvider()
    {
        return [
            [ConfigService::UP_TO_DATE, ['app_ver' => "1.2", 'lang_ver' => "1.4",]],
            [ConfigService::FORCE_UPDATE, ['app_ver' => "0.3", 'lang_ver' => "1.4",]],
            [ConfigService::FORCE_UPDATE, ['app_ver' => "1.2", 'lang_ver' => "0.5",]],
            [ConfigService::SOFT_UPDATE, ['app_ver' => "1.1", 'lang_ver' => "1.4",]],
            [ConfigService::SOFT_UPDATE, ['app_ver' => "1.2", 'lang_ver' => "1.2",]],
        ];
    }
}
