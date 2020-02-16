<?php

namespace App\Services;

use Illuminate\Support\Str;

class ConfigService
{
    private $config = [];

    private $versions = [];

    private $currentConfig;

    const FORCE_UPDATE = "force_update";
    const SOFT_UPDATE = "soft_update";
    const UP_TO_DATE = "up_to_date";

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function getCurrentConfig()
    {
        return $this->currentConfig;
    }

    public function setCurrentConfig($config)
    {
        $this->currentConfig = $config;
    }

    public function checkVersion()
    {
        $this->fillVersions();
        return $this->validateVersions();

    }

    private function validateVersions()
    {
        $response = null;
        $oldResponse = null;
        foreach ($this->versions as $version) {
            if ($version['user']['base_ver'] < $version['server']['base_ver']) {
                $response = self::FORCE_UPDATE;
            } elseif ($version['user']['sub_ver'] < $version['server']['sub_ver']) {
                $response = self::SOFT_UPDATE;
            } else {
                $response = self::UP_TO_DATE;
            }
            if ($response == self::UP_TO_DATE && $oldResponse == self::SOFT_UPDATE) return self::SOFT_UPDATE;
            $oldResponse = $response;
            if ($response == self::FORCE_UPDATE) return self::FORCE_UPDATE;
        }
        return $response;
    }

    public function fillVersions()
    {
        foreach ($this->config as $key => $value) {
            if (Str::contains($key, 'ver')) {
                $this->versions[$key]['user'] = $this->parseVersion($value);
                $this->versions[$key]['server'] = $this->parseVersion($this->currentConfig[$key]);
            }
        }
    }

    /**
     * versiyonları sub ve base olarak parçalar
     * @param string $version
     * @return array
     */
    private function parseVersion(string $version)
    {
        $ver = explode('.', $version);
        return [
            'base_ver' => $ver[0] ?? "0",
            'sub_ver' => $ver[1] ?? "0"
        ];
    }
}
