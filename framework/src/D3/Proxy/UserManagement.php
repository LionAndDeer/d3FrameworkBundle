<?php

namespace Liondeer\Framework\D3\Proxy;

use Exception;
use Liondeer\Model\GroupModel;
use Psr\Log\LoggerInterface;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserManagement
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private LoggerInterface $logger
    ) {
    }

    public function getGroupList(string $accessToken, string $baseUri): array
    {
        $userlist = [];
        try {
            $response = $this->httpClient->request(
                'GET',
                $baseUri . '/usermanagement/group',
                [
                    'headers' => [
                        'authorization' => 'Bearer ' . $accessToken,
                        'accept' => 'application/json'
                    ]
                ]
            );
            $normalizers = [
                new ArrayDenormalizer(),
                new ObjectNormalizer(propertyTypeExtractor: new ReflectionExtractor())
            ];
            $encoders = [new JsonEncoder()];

            $serializer = new Serializer($normalizers, $encoders);
            $userlist = $serializer->deserialize(
                json_encode($response->toArray()['groups']),
                GroupModel::class . '[]',
                'json'
            );
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage());
        }

        return $userlist;
    }

}