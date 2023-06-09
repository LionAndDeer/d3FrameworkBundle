<?php

namespace Liondeer\Framework\D3\Proxy;

use JetBrains\PhpStorm\ArrayShape;
use Liondeer\Framework\D3\Model\Dms\DMSObject;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

//use Liondeer\Transmitter\Model\DatevConnectOnline\V1\DocumentModel;
//use Symfony\Component\Filesystem\Filesystem;

class DMS
{
    private array $headers;

    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getStorageDocTypeId(string $name, string $authToken, string $baseUri): string
    {
        $this->setHeaders($authToken);
        $response = $this->client->request(
            'GET',
            $baseUri . '/dms/r/' . $this->getRepositoryId($baseUri, $authToken) . '/storedoctype',
            ['headers' => $this->headers]
        );

        $data = json_decode($response->getContent(), true);

        foreach ($data['storageDocumentTypes'] as $storageDocType) {
            if ($storageDocType['displayName'] === $name) {
                return $storageDocType['id'];
            }
        }

        return "";
    }
    public function getDocumentCategories(string $authToken, string $baseUri, string $tenantId)
    {
        $this->setHeaders($authToken);
        $repoId = $this->getRepositoryId($baseUri, $authToken);
        $response = $this->client->request('GET', $baseUri.'/dmsconfig/r/'.$repoId.'/objectmanagement/categories/', ['headers' => $this->headers]);
        $categories = json_decode($response->getContent())->_embedded->categories;
        return $categories;
    }

    public function getPropertiesToCategory(string $categorieId, string $baseUrl, $authToken) {
        $this->setHeaders($authToken);
        $repoId = $this->getRepositoryId($baseUrl, $authToken);
        $response = $this->client->request('GET', $baseUrl.'/dmsconfig/r/'.$repoId.'/objectmanagement/categories/'.$categorieId.'/properties', ['headers' => $this->headers]);
        $content = json_decode($response->getContent());
        return $content->_embedded->properties;
    }

    private function setHeaders(string $authToken, ?string $acceptHeader = 'application/hal+json')
    {
        $this->headers = [
            'Authorization' => 'Bearer ' . $authToken
        ];

        if (null !== $acceptHeader) {
            $this->headers['Accept'] = $acceptHeader;
        }
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getRepositoryId(string $baseUri, string $authToken): string
    {
        $this->setHeaders($authToken);
        $response = $this->client->request(
            'GET',
            $baseUri.'/dms/r',
            ['headers' => $this->headers]
        );
        $data = json_decode($response->getContent(), true);

        return $data['repositories'][0]['id'];
    }

    /**
     * @throws ClientExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws TransportExceptionInterface
     */
    #[ArrayShape(['contentLocationUri' => "string", 'dmsObjectId' => "mixed", 'documentUrl' => "string"])]
    public function createDmsEntry(
        DMSObject $dmsObject,
        string $fileContents,
        string $baseUri,
        string $authToken
    ): array {
        $this->setHeaders($authToken);
        $repositoryId = $this->getRepositoryId($baseUri, $authToken);
        $response =  $this->client->request(
            'POST',
            $baseUri . '/dms/r/' . $repositoryId . '/blob/chunk/',
            [
                'headers' => $this->headers + ['Content-Type' => 'Application/octet-stream'],
                'body' => $fileContents
            ]
        );
        $contentLocationUri = $response->getHeaders()['location'][0];
        $dmsObject->setContentLocationUri($contentLocationUri);

        $response = $this->client->request(
            'POST',
            $baseUri . '/dms/r/' . $repositoryId . '/o2m',
            [
                'headers' => $this->headers,
                'body' => $dmsObject->serialize(),
            ]
        );
        $content = $response->getContent(false);
        $contentLocationUri = $response->getHeaders()['location'][0];
        preg_match('%o2m/(.*)\?sourceid%', $contentLocationUri, $matches);
        $dmsObjectId = $matches[1];
        $documentUrl = $baseUri . $this->getImageLocation($dmsObjectId, $baseUri, $authToken);

        return [
            'contentLocationUri' => $contentLocationUri,
            'dmsObjectId' => $dmsObjectId,
            'documentUrl' => $documentUrl,
            'repositoryId' =>$repositoryId,
        ];
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getImageLocation(string $dmsObjectId, string $baseUri, string $authToken): string
    {
        $this->setHeaders($authToken);
        $response = $this->client->request(
            'GET',
            $baseUri . '/dms/r/' . $this->getRepositoryId($baseUri, $authToken) . '/o2/' . $dmsObjectId,
            [
                'headers' => $this->headers + ['Accept' => 'application/hal+json'],
            ]
        );

        return json_decode($response->getContent(), true)['previewState']['sourceUri'];
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getDocumentUri(string $dmsObjectId, string $baseUri, string $authToken): string
    {
        $this->setHeaders($authToken);

        $response = $this->client->request(
            'GET',
            $baseUri . '/dms/r/' . $this->getRepositoryId($baseUri, $authToken) . '/o2/' . $dmsObjectId . '/v',
            [
                'headers' => $this->headers + ['Accept' => 'application/hal+json'],
            ]
        );

        return json_decode($response->getContent(), true)['versions'][0]['_links']['mainblobcontent']['href'];
    }

    /**
     * @throws ClientExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function updateDmsEntry(
        DMSObject $dmsObject,
        string $dmsObjectId,
        string $baseUri,
        string $authToken,
        string $fileContents = null
    ): string {
        $this->setHeaders($authToken);
        $repositoryId = $this->getRepositoryId($baseUri, $authToken);
        if (null != $fileContents) {
            $response = $this->client->request(
                'POST',
                $baseUri . '/dms/r/' . $repositoryId . '/blob/chunk/',
                [
                    'headers' => $this->headers + ['Content-Type' => 'Application/octet-stream'],
                    'body' => $fileContents
                ]
            );
            $contentLocationUri = $response->getHeaders()['location'][0];
            $dmsObject->setContentLocationUri($contentLocationUri);
        }

        $response = $this->client->request(
            'PUT',
            $baseUri . '/dms/r/' . $repositoryId . '/o2m/' . $dmsObjectId,
            [
                'headers' => $this->headers,
                'body' => $dmsObject->serialize(),
            ]
        );

        return $baseUri . $this->getImageLocation($dmsObjectId, $baseUri, $authToken);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function deleteDmsObject(
        string $dmsObjectId,
        string $baseUri,
        string $repositoryId,
        string $authToken
    ): string {
        $this->setHeaders($authToken);
        $response = $this->client->request(
            'DELETE',
            $baseUri . '/dms/r/' . $repositoryId . '/o2m/' . $dmsObjectId,
            [
                'headers' => $this->headers,
                'body' => json_encode(['reason' => 'Kassenbucheintrag gelöscht']),
            ]
        );

        while (!empty($response->getContent())) {
            $content = json_decode($response->getContent(), true);
            dump($content);

            $deleteUrl = $content['_links']['deleteWithReason']['href'];

            if (empty($content['_links']['deleteWithReason'])) {
                $deleteUrl = $content['_links']['delete']['href'];
            }

            $response = $this->client->request(
                'DELETE',
                $baseUri . $deleteUrl,
                [
                    'headers' => $this->headers,
                    'body' => json_encode(['reason' => 'Kassenbucheintrag gelöscht']),
                ]
            );

            if (!empty($response->getContent())) {
                return json_decode($response->getContent(), true)['reason'];
            }
        }

        return "";
    }

    //TODO unabhängig vom Transmitter machen
//    /**
//     * @throws TransportExceptionInterface
//     */
//    public function getOriginalDocument(
//        DocumentModel $documentModel,
//        string $authToken,
//        ?string $smartInvoiceToken = null
//    ): string {
//        if ($smartInvoiceToken != null) {
//            $authToken = $smartInvoiceToken;
//        }
//        $this->setHeaders($authToken, null);
//
//        $filesystem = new Filesystem();
//        $response = $this->client->request(
//            'GET',
//            $documentModel->getTenant()->getBaseUri().$documentModel->getDmsObjectUri(),
//            ['headers' => $this->headers]
//        );
//
//        $fileName = sys_get_temp_dir().'/'
//            .$documentModel->getTenant()->getTenantId().'/'
//            .$documentModel->getTicket()->getId().'/'
//            .$documentModel->getDocumentId().'.'.$documentModel->getFileType();
//
//        foreach ($this->client->stream($response) as $chunk) {
//            $filesystem->appendToFile($fileName, $chunk->getContent());
//        }
//
//        return $fileName;
//    }

    private function getFilenameFromResponseHeaders(array $headers): ?string
    {
        $dispositionHeader = urldecode(trim($headers['content-disposition'][0]));
        $matches = [];
        preg_match("/filename\*?=[^']*''[^'(]*\(?([^;]*)\).(.*)/", $dispositionHeader, $matches);

        return $matches[1].'.'.$matches[2];
    }
}
