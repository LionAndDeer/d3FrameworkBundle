<?php

namespace Liondeer\Framework\D3\Proxy\IdentityProvider;

use Exception;
use Liondeer\Framework\D3\Model\UserResponse;
use Liondeer\Framework\Exception\LiondeerD3FrameworkException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class UserProxy
{
    public function __construct(
        private SerializerInterface $serializer
    )
    {
    }

    public function validate(string $bearerToken, array $credentials): UserResponse
    {
        //TODO wenn sessionId schon im cache: request gar nich losschicken
        $httpClient = HttpClient::create();
        try {
            $response = $httpClient->request(
                Request::METHOD_GET,
                $credentials['d3BaseUri'] . '/identityprovider/validate',
                [
                    'headers' => [
                        'Content-Type' => 'application/json; charset=utf-8',
                        'Origin' => $credentials['d3BaseUri'],
                        'Authorization' => 'Bearer ' . $bearerToken
                    ],
                ]
            );
            return $this->serializer->deserialize($response->getContent(), UserResponse::class, 'json');
        } catch (Exception $e) {
            throw new LiondeerD3FrameworkException(
                'Daten des aktuellen Nutzers konnten nicht geladen werden',
                1005
            );
        }
    }
}