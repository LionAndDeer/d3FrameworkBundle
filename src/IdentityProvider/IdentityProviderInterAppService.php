<?php

namespace Liondeer\Framework\IdentityProvider;

use DateTime;
use Exception;
use Liondeer\Framewor\D3\Model\AppSession;
use Liondeer\Framework\D3\Model\AppSessionCallback;
use Liondeer\Framework\Exception\LiondeerD3FrameworkException;
use Liondeer\Framework\Model\Tenant;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class IdentityProviderInterAppService
{
    const TENANT_CACHE_FILE = "sessionId_tenant_";
    private LoggerInterface $logger;

    public function __construct(
        private ParameterBagInterface $params,
        private SerializerInterface $serializer,
        private CacheItemPoolInterface $cache,
        private HttpClientInterface $client,
        private UrlGeneratorInterface $router
    )
    {
    }

    /**
     * @param Tenant $tenant
     * @return mixed
     * @throws InvalidArgumentException
     * @throws LiondeerD3FrameworkException
     * @throws TransportExceptionInterface
     */
    public function getSessionId(Tenant $tenant): mixed
    {
        if (!$this->isSessionInCache($tenant->getTenantId())) {
            $response = $this->requestAuthenticationId($tenant);
            if ($response->getStatusCode() != Response::HTTP_OK) {
//                TODO: Logging
//                $this->logger->info("Authentifizierung fehlgeschlagen");
                throw new LiondeerD3FrameworkException("Authentifizierung fehlgeschlagen", "LD-1003");
            }
        }
        return $this->cache->getItem(self::TENANT_CACHE_FILE . $tenant->getTenantId())->get();
    }

    /**
     * @param string $tenantId
     * @return bool
     * @throws InvalidArgumentException
     */
    private function isSessionInCache(string $tenantId): bool
    {
        $sessionId = $this->cache->getItem(self::TENANT_CACHE_FILE . $tenantId);
        if (!$sessionId->isHit()) {
            return false;
        }

        return true;
    }

    /**
     * @param Tenant $tenant
     * @return Response
     * @throws InvalidArgumentException
     * @throws Exception
     * @throws TransportExceptionInterface
     */
    private function requestAuthenticationId(Tenant $tenant): Response
    {
        $appSession = new AppSession($this->params);
        $appSession->setCallback(
            $this->router->generate(
                'interAppAuthenticationCallback',
                [
                    'tenantId' => $tenant->getTenantId(),
                    'requestId' => $appSession->getRequestId()
                ]
            )
        );

        $baseUri = $tenant->getBaseUri();

        $response = $this->client->request(
            Request::METHOD_POST,
            $baseUri . '/identityprovider/appsession',
            [
                'headers' => [
                    'Content-Type' => 'application/json; charset=utf-8',
                    'Accept' => 'application/json',
                    'Origin' => $baseUri,
                ],
                'body' => $this->serializer->serialize($appSession, "json"),
            ]
        );

        if($response->getStatusCode() != Response::HTTP_OK) {
            $response->getContent();
        }

        if (!$this->waitForSessionCallback($tenant->getTenantId())) {
            return new Response("", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new Response("");
    }

    /**
     * @param string $tenantId
     * @param int $attempts
     * @return bool
     * @throws InvalidArgumentException
     */
    private function waitForSessionCallback(string $tenantId, int $attempts = 0): bool
    {
        if ($attempts == 10) {
            return false;
        }

        if (!$this->isSessionInCache($tenantId)) {
            sleep(1);
            $this->waitForSessionCallback($tenantId, $attempts + 1);
        }

        return true;
    }

    /**
     * @param string $requestId
     * @param string $tenantId
     * @param string $content
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function interAppAuthenticationCallback(string $requestId, string $tenantId, string $content)
    {
        // Hier kein Breakpoint weil Code außerhalb des Request sonst nicht weiterläuft

        /** @var AppSessionCallback $appSessionCallback */
        $appSessionCallback = $this->serializer->deserialize($content, AppSessionCallback::class, "json");

        $signature = hash(
            "sha256",
            $this->params->get("d3_app_name") . $appSessionCallback->getAuthSessionId() . $appSessionCallback->getExpire() . $requestId
        );

        $this->cache->deleteItem(self::TENANT_CACHE_FILE . $tenantId);

        if ($signature == $appSessionCallback->getSign()) {
            $item = $this->cache->getItem(self::TENANT_CACHE_FILE . $tenantId);
            $item->set($appSessionCallback->getAuthSessionId());

            $currentDateTime = new DateTime("now");
            $expireDateTime = new DateTime($appSessionCallback->getExpire());
            $expireDateTime->setTimezone($currentDateTime->getTimezone());

            $item->expiresAt($expireDateTime);

            $this->cache->save($item);
        }
    }

}