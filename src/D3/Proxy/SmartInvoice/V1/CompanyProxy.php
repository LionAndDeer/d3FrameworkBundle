<?php

namespace Liondeer\Framework\D3\Proxy\SmartInvoice\V1;

use Liondeer\Framework\D3\Model\SmartInvoice\V1\CompanyModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\JobModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\SyncMetadataModel;
use Psr\Log\LoggerInterface;

class CompanyProxy extends AbstractSmartInvoiceProxy
{
    public function __construct(
        protected LoggerInterface $logger,
    ) {
        parent::__construct(AbstractSmartInvoiceProxy::COMPANY);
    }

    /**
     * @param CompanyModel[] $companies
     */
    public function batchData(array $companies, SyncMetadataModel $syncMetadata): JobModel
    {
        $data['companies'] = $this->serializer->normalize($companies, CompanyModel::class);

        $result = $this->doRequest($data, $syncMetadata);

        $jobs = json_decode($result->getContent());
        $this->logger->info('Companies batch result',
            [
                'jobs' => $jobs,
                'companies' => json_encode($data),
            ]
        );

        return $this->serializer->denormalize($jobs->jobs[0], JobModel::class);
    }
}
