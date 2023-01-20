<?php

namespace Liondeer\Framework\D3\Proxy\SmartInvoice\V1;

use Exception;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\JobModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\SyncMetadataModel;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class MasterdataImportJobsProxy implements LoggerAwareInterface
{
    use LoggerAwareTrait;
    private Serializer $serializer;
    private string $apiUrl = '%s/smartinvoice/api/v1/masterdata/import_jobs/%s';

    public function __construct()
    {
        $this->setupSerializer();
    }

    private function setupSerializer()
    {
        $normalizers = [new GetSetMethodNormalizer(null, new CamelCaseToSnakeCaseNameConverter())];
        $encoders = [new JsonEncoder()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public function getJob(SyncMetadataModel $syncMetadata, string $jobId): JobModel
    {
        $result = $this->doRequest($syncMetadata, $jobId);

        $job = json_decode($result->getContent());
        $this->logger->info('Jobstatus result', ['job' => $result->getContent()]);

        return $this->serializer->denormalize($job, JobModel::class);
    }

    private function doRequest(SyncMetadataModel $syncMetadata, string $jobId)
    {
        $method = 'GET';

        $url = sprintf(
            $this->apiUrl,
            $syncMetadata->getBaseUrl(),
            $jobId
        );

        $httpClient = HttpClient::create();
        try {
            $result = $httpClient->request(
                $method,
                $url,
                [
                    'headers' => [
                        'Origin' => $syncMetadata->getBaseUrl(),
                        'authorization' => 'Bearer '.$syncMetadata->getSiApiKey(),
                    ],
                ]
            );

            return $result;
        } catch (Exception $e) {
            $this->logger->error('Fehler beim Schreiben nach SmartInvoice!', ['exception' => $e->getMessage()]);

            return null;
        }
    }
}
