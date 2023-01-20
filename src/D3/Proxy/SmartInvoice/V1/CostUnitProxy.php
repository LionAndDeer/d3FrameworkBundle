<?php

namespace Liondeer\Framework\D3\Proxy\SmartInvoice\V1;

use Liondeer\Framework\D3\Model\SmartInvoice\V1\CostUnitModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\JobModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\SyncMetadataModel;
use Psr\Log\LoggerInterface;

class CostUnitProxy extends AbstractSmartInvoiceProxy
{
    public function __construct(
        protected LoggerInterface $logger,
    )
    {
        parent::__construct(AbstractSmartInvoiceProxy::COST_UNIT);
    }

    /**
     * @param CostUnitModel[] $costUnits
     */
    public function batchData(array $costUnits, SyncMetadataModel $syncMetadata): JobModel
    {
        $data['cost_units'] = $this->serializer->normalize($costUnits, CostUnitModel::class);

        $result = $this->doRequest($data, $syncMetadata);

        $jobs = json_decode($result->getContent());
        $this->logger->info("Cost units batch result", ['jobs' => $jobs]);

        return $this->serializer->denormalize($jobs->jobs[0], JobModel::class);
    }
}