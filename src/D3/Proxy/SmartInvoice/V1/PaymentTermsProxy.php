<?php

namespace Liondeer\Framework\D3\Proxy\SmartInvoice\V1;

use Liondeer\Framework\D3\Model\SmartInvoice\V1\JobModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\PaymentTermsModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\SyncMetadataModel;
use Psr\Log\LoggerInterface;

class PaymentTermsProxy extends AbstractSmartInvoiceProxy
{
    public function __construct(
        protected LoggerInterface $logger,
    ) {
        parent::__construct(AbstractSmartInvoiceProxy::PAYMENT_TERMS);
    }

    /**
     * @param PaymentTermsModel[] $paymentTerms
     */
    public function batchData(array $paymentTerms, SyncMetadataModel $syncMetadata): JobModel
    {
        $data['payment_terms'] = $this->serializer->normalize($paymentTerms, PaymentTermsModel::class);

        $result = $this->doRequest($data, $syncMetadata);

        $jobs = json_decode($result->getContent());
        $this->logger->info('Payment terms batch result', ['jobs' => $jobs]);

        return $this->serializer->denormalize($jobs->jobs[0], JobModel::class);
    }
}
