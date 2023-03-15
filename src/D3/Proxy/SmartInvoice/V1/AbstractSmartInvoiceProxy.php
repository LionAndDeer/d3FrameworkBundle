<?php

namespace Liondeer\Framework\D3\Proxy\SmartInvoice\V1;

use Exception;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\SyncMetadataModel;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class AbstractSmartInvoiceProxy
{
    public const COMPANY = 'companies';
    public const VENDOR = 'vendors';
    public const VENDOR_BANK_ACCOUNT = 'vendor_bank_accounts';
    public const PAYMENT_TERMS = 'payment_terms';
    public const TAX_CODE = 'tax_codes';
    public const GL_ACCOUNT = 'gl_accounts';
    public const COST_CENTER = 'cost_centers';
    public const COST_UNIT = 'cost_units';

    protected LoggerInterface $logger;
    protected Serializer $serializer;
    protected string $apiUrl = '%s/smartinvoice/api/v1/buckets/%s/%s/batch';

    public function __construct(
        protected string $apiEndpoint,
    ) {
        $this->setupSerializer();
    }

    private function setupSerializer()
    {
        $normalizers = [new GetSetMethodNormalizer(null, new CamelCaseToSnakeCaseNameConverter())];
        $encoders = [new JsonEncoder()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    protected function doRequest(array $data, SyncMetadataModel $syncMetadata)
    {
        $method = 'POST';

        $url = sprintf(
            $this->apiUrl,
            $syncMetadata->getBaseUrl(),
            $syncMetadata->getBucketId(),
            $this->apiEndpoint
        );


        $httpClient = HttpClient::create();
        try {
            $result = $httpClient->request(
                $method,
                $url,
                [
                    'headers' => [
                        'Origin' => $syncMetadata->getBaseUrl(),
                        'Content-Type' => 'application/json;charset=utf-8',
                        'authorization' => 'Bearer '.$syncMetadata->getSiApiKey(),

                    ],
                    'body' => json_encode($data),
                ]
            );

            return $result;
        } catch (Exception $e) {
            $this->logger->error('Fehler beim Schreiben nach SmartInvoice!', ['exception' => $e->getMessage()]);

            return null;
        }
    }
}
