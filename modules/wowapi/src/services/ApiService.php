<?php
namespace modules\wowapi\services;

use Craft;
use craft\base\Component;
use craft\helpers\App;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class ApiService extends Component
{
    protected Client $_http;

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->_http = new Client(['timeout' => 5]);
    }

    public function getGuildRoster(): array
    {
        $cacheKey = 'wowroster';
        if ($cached = Craft::$app->cache->get($cacheKey)) {
            return $cached;
        }

        $accessKey = App::env('RAIDER_IO_ACCESS_KEY');
        $url = 'https://raider.io/api/v1/guilds/profile';
        $query = [
            'access_key' => $accessKey,
            'region'     => 'us',
            'realm'      => 'dalaran',
            'name'       => 'FAT AND BADASS',
            'fields'     => 'members',
        ];

        try {
            $resp    = $this->_http->get($url, ['query' => $query]);
            $payload = json_decode((string)$resp->getBody(), true);
            $members = $payload['members'] ?? [];

            // cache for 5m
            Craft::$app->cache->set($cacheKey, $members, 300);
            return $members;

        } catch (ClientException|ServerException $e) {
            $code = $e->getResponse()->getStatusCode();
            $body = (string)$e->getResponse()->getBody();
            Craft::error("Raider.IO HTTP {$code}: {$body}", __METHOD__);
            throw $e;
        } catch (\Throwable $e) {
            Craft::error('Unexpected WoW API error: '.$e->getMessage(), __METHOD__);
            return [];
        }
    }
}
