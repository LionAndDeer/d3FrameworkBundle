<?php

namespace Liondeer\Framework\D3\Proxy\SmartInvoice\V1;

use Liondeer\Framework\D3\Model\SmartInvoice\V1\GlAccountModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\JobModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\SyncMetadataModel;
use Psr\Log\LoggerInterface;

class GlAccountProxy extends AbstractSmartInvoiceProxy
{
    public function __construct(
        protected LoggerInterface $logger,
    )
    {
        parent::__construct(AbstractSmartInvoiceProxy::GL_ACCOUNT);
    }

    /**
     * @param GlAccountModel[] $glAccounts
     */
    public function batchData(array $glAccounts, SyncMetadataModel $syncMetadata): JobModel
    {
        $data['gl_accounts'] = $this->serializer->normalize($glAccounts, GlAccountModel::class);

        $result = $this->doRequest($data, $syncMetadata);

        $jobs = json_decode($result->getContent());
        $this->logger->info("G/L Accounts batch result", ['jobs' => $jobs]);

        return $this->serializer->denormalize($jobs->jobs[0], JobModel::class);
    }
}