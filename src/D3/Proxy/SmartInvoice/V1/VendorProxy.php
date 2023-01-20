<?php

namespace Liondeer\Framework\D3\Proxy\SmartInvoice\V1;

use Liondeer\Framework\D3\Model\SmartInvoice\V1\JobModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\SyncMetadataModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\VendorModel;
use Psr\Log\LoggerInterface;

class VendorProxy extends AbstractSmartInvoiceProxy
{
    public function __construct(
        protected LoggerInterface $logger,
    )
    {
        parent::__construct(AbstractSmartInvoiceProxy::VENDOR);
    }

    /**
     * @param VendorModel[] $vendors
     */
    public function batchData(array $vendors, SyncMetadataModel $syncMetadata): JobModel
    {
        $data['vendors'] = $this->serializer->normalize($vendors, VendorModel::class);

        $result = $this->doRequest($data, $syncMetadata);

        $jobs = json_decode($result->getContent());
        $this->logger->info("Vendors batch result", ['jobs' => $jobs]);

        return $this->serializer->denormalize($jobs->jobs[0], JobModel::class);
    }
}