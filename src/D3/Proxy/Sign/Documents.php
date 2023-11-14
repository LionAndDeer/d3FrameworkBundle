<?php

namespace Liondeer\Framework\D3\Proxy\Sign;


use Liondeer\Framework\D3\Model\Sign\DocumentMetaDataModel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Documents
{
    private array $headers;

    public function __construct(
        private HttpClientInterface $client,
        private SerializerInterface $serializer,
    )
    {

    }

    private function setHeaders(string $authToken, ?string $acceptHeader = 'application/hal+json')
    {
        $this->headers = [
            'Authorization' => 'Bearer ' . $authToken,
            'Content-Type' => 'application/json'
        ];
    }


    public function postDoucments(string $baseUri, string $authToken, string $documentName): bool | string
    {
        $this->setHeaders($authToken);

        $response = $this->client->request(
            'POST',
            $baseUri . '/sign/api/documents',
            [
                'headers' => $this->headers,
                'body' => json_encode([
                    'fileName' => $documentName,
                ]) //TODO ab Symfony 6.4 kann hier wieder ein Array stehen. Momentan wird der Content-Type überschrieben, wenn ein Array übergeben wird
            ]);

        if (!$response->getStatusCode() === Response::HTTP_CREATED) {
            return false;
        }
        $responseHeaders = $response->getHeaders(false);


        // ID auslesen aus "/sign/api/documents/<documentId>"

        $documentLocation = $responseHeaders['location'];
        $documentLocationElemets = explode('/',$documentLocation[0]);
        return end($documentLocationElemets);
    }

    public function getDocumentFromId(string $baseUri, string $authToken, string $documentId): DocumentMetaDataModel
    {
        $this->setHeaders($authToken);
        $response = $this->client->request(
            'GET',
            $baseUri . '/sign/api/documents/' . $documentId,
            [
                'headers' => $this->headers,

            ]
        );
        $content = $response->getContent();
        $documentModel = $this->serializer->deserialize($response->getContent(),DocumentMetaDataModel::class,'json');
        return $documentModel;

    }

    public function uploadDocumentPerUploadLink(string $uploadLink, $documentStream): bool
    {

        $headers['Content-Type'] = 'application/x-www-form-urlencoded';

        $response = $this->client->request(
            'PUT',
            $uploadLink,
            [
                'headers' => $headers,
                'body' => $documentStream,
            ]
        );
        
        if ($response->getStatusCode(false) === Response::HTTP_NO_CONTENT) {
            return true;
        } else {
            return false;
        }
    }

    public function updateDocumentEvent(string $baseUri, string $authToken, string $documentId, string $eventType)
    {
        $this->setHeaders($authToken);
        $response = $this->client->request(
            'POST',
            $baseUri . '/sign/api/documents/' . $documentId . '/event',
            [
                'headers' => $this->headers,
                'body' => json_encode(['eventType' => $eventType,]) //TODO ab Symfony 6.4 kann hier wieder ein Array stehen. Momentan wird der Content-Type überschrieben, wenn ein Array übergeben wird
            ]
        );

        if ($response->getStatusCode(false) === Response::HTTP_NO_CONTENT) {
            return true;
        } else {
            return false;
        }
    }

}

