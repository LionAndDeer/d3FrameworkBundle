<?php

namespace Liondeer\Framework\D3\Proxy\HttpGateway;

use Liondeer\Framework\D3\Model\HttpGateway\AppModel;
use Liondeer\Framework\D3\Model\HttpGateway\SubscribedAppsModel;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SubscribedAppsProxy
{
    public function __construct(
        private HttpClientInterface $httpClient,
    )
    {
    }

    public function getSubscribedApps(string $tenantOrigin): false|SubscribedAppsModel
    {
        $counter = 10;
        while ($counter > 0) {
            try {
                $response = $this->httpClient->request(
                    'GET',
                    "$tenantOrigin/httpgateway/conf/apps",
                    [
                        'headers' => [
                            'accept' => 'application/json'
                        ]
                    ]
                );
                $content = $response->toArray();
                $counter = -1;
            } catch (\Exception $exception) {
                // TODO: logging
                sleep(2);
                $counter -= 1;
            }
        }
        if (empty($content)) {
            return false;
        }
        $subscribedAppsModel = new SubscribedAppsModel();
        foreach ($content['apps'] as $app) {
            $subscribedAppsModel->addSubscribedApp($app['app']);
        }
        return $subscribedAppsModel;
    }
}