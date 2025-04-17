<?php
namespace modules\wowapi\controllers;

use Craft;
use craft\web\Controller;
use modules\wowapi\Module as WowApi;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GuildController extends Controller
{
    protected array|bool|int $allowAnonymous = ['action-roster'];

    public function actionRoster()
    {
        try {
            $payload = WowApi::getInstance()->apiService->getGuildRoster();
            return $this->asJson($payload);
        } catch (GuzzleException $e) {
            Craft::$app->getResponse()->setStatusCode(502);
            return $this->asJson([
                'error'   => 'Upstream API error',
                'details' => $e->getResponse() 
                    ? (string)$e->getResponse()->getBody() 
                    : $e->getMessage(),
            ]);
        } catch (\Throwable $e) {
            Craft::$app->getResponse()->setStatusCode(500);
            return $this->asJson([
                'error'   => 'Internal error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function actionShow()
    {
        $members = WowApi::getInstance()->apiService->getGuildRoster();
        return $this->renderTemplate('guild-roster', [
            'members' => $members
        ]);
    }
}
