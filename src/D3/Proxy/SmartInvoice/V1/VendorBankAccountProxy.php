<?php

namespace Liondeer\Framework\D3\Proxy\SmartInvoice\V1;

use Liondeer\Framework\D3\Model\SmartInvoice\V1\JobModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\SyncMetadataModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\VendorBankAccountModel;
use Psr\Log\LoggerInterface;

class VendorBankAccountProxy extends AbstractSmartInvoiceProxy
{
    public function __construct(
        protected LoggerInterface $logger,
    )
    {
        parent::__construct(AbstractSmartInvoiceProxy::VENDOR_BANK_ACCOUNT);
    }

    /**
     * @param VendorBankAccountModel[] $vendorBankAccounts
     */
    public function batchData(array $vendorBankAccounts, SyncMetadataModel $syncMetadata): JobModel
    {
        $data['vendor_bank_accounts'] = $this->serializer->normalize($vendorBankAccounts, VendorBankAccountModel::class);

        $result = $this->doRequest($data, $syncMetadata);

        $jobs = json_decode($result->getContent());
        $this->logger->info("VendorBankAccounts batch result", ['jobs' => $jobs, 'data' => $data]);

        return $this->serializer->denormalize($jobs->jobs[0], JobModel::class);
    }
}