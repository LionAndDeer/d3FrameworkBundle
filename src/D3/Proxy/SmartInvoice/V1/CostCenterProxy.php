<?php

namespace Liondeer\Framework\D3\Proxy\SmartInvoice\V1;

use Liondeer\Framework\D3\Model\SmartInvoice\V1\CostCenterModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\JobModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\SyncMetadataModel;
use Psr\Log\LoggerInterface;

class CostCenterProxy extends AbstractSmartInvoiceProxy
{
    public function __construct(
        protected LoggerInterface $logger,
    ) {
        parent::__construct(AbstractSmartInvoiceProxy::COST_CENTER);
    }

    /**
     * @param CostCenterModel[] $costCenters
     */
    public function batchData(array $costCenters, SyncMetadataModel $syncMetadata): JobModel
    {
        $data['cost_centers'] = $this->serializer->normalize($costCenters, CostCenterModel::class);

        $result = $this->doRequest($data, $syncMetadata);

        $jobs = json_decode($result->getContent());
        $this->logger->info('Cost centers batch result',
            [
                'jobs' => $jobs,
                'cost_centers' => json_encode($data),
            ]
        );

        return $this->serializer->denormalize($jobs->jobs[0], JobModel::class);
    }
}
