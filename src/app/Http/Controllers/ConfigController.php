<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfigRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\ConfigResource;
use App\Http\Resources\ConfigResultResource;
use App\Http\Resources\SongResource;
use App\Services\ConfigService;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /** @var ConfigService */
    protected $configService;

    const UP_TO_DATE_CODE = 10;
    const UP_TO_DATE_MESSAGE = "Version is up to date";
    const FORCE_UPDATE_CODE = 11;
    const FORCE_UPDATE_MESSAGE = "Application require force update";
    const SOFT_UPDATE_CODE = 11;
    const SOFT_UPDATE_MESSAGE = "Application version not up to date";

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }

    /** @SWG\Get(
     *     path="/api/config",
     *     tags={"Config"},
     *     summary="Ayarlar dosyasını indirir",
     *     description="Ayarlar dosyasını indirir",
     *     @SWG\Response(
     *          response=200,
     *          description="işlem başarılı",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="errorCode",
     *                  type="int"
     *             ),
     *             @SWG\Property(
     *                  property="errorMessage",
     *                  type="string"
     *             ),
     *             @SWG\Property(
     *                  property="data",
     *                  type="string"
     *             )
     *          )
     *     ),
     *     @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *     )
     * )
     * @return ConfigResource
     */
    public function get()
    {
        $config = config('app_config');
        return new ConfigResource($config, BaseResource::HTTP_OK, BaseResource::$statusTexts[200]);
    }

    /** @SWG\Post(
     *     path="/api/config/check",
     *     tags={"Config"},
     *     summary="Ayarları kontrol eder",
     *     description="Ayarlar kontrol eder",
     *     @SWG\Parameter(
     *          name="app_ver",
     *          description="app_ver",
     *          required=true,
     *          type="string",
     *          in="query"
     *     ),@SWG\Parameter(
     *          name="lang_ver",
     *          description="lang_ver",
     *          required=true,
     *          type="string",
     *          in="query"
     *     ),
     *     @SWG\Response(
     *          response=200,
     *          description="işlem başarılı",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="errorCode",
     *                  type="int"
     *             ),
     *             @SWG\Property(
     *                  property="errorMessage",
     *                  type="string"
     *             ),
     *             @SWG\Property(
     *                  property="data",
     *                  type="string"
     *             )
     *          )
     *     ),
     *     @SWG\Response(
     *          response=401,
     *          description="Unauthorized"
     *     )
     * )
     * @param ConfigRequest $request
     * @return ConfigResultResource
     */
    public function check(ConfigRequest $request)
    {
        $config = $request->all();
        $this->configService->setConfig($config);
        $this->configService->setCurrentConfig(config('app_config'));
        $result = $this->configService->checkVersion();

        if ($result == ConfigService::FORCE_UPDATE) {
            return new ConfigResultResource(null, self::FORCE_UPDATE_CODE, self::FORCE_UPDATE_MESSAGE);
        } else if ($result == ConfigService::SOFT_UPDATE) {
            return new ConfigResultResource(null, self::SOFT_UPDATE_CODE, self::SOFT_UPDATE_MESSAGE);
        } else {
            return new ConfigResultResource(null, self::UP_TO_DATE_CODE, self::UP_TO_DATE_MESSAGE);
        }
    }
}
