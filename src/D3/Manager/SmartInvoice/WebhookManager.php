<?php

namespace Liondeer\Framework\D3\Manager\SmartInvoice;

use Liondeer\Framework\D3\Model\SmartInvoice\V1\Webhook\WorkflowModel;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class WebhookManager
{
    private Serializer $serializer;

    public function __construct(
        private RequestStack    $requestStack,
        private LoggerInterface $logger
    )
    {
        $this->setupSerializer();
    }

    /**
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function getWorkflowModel(): WorkflowModel
    {
        $data = $this->requestStack->getCurrentRequest()->getContent();
        $this->logger->info("[WebhookManager] SI-Daten", ['data' => $data]);

        /** @var WorkflowModel $workflow */
        $workflow = $this->serializer->deserialize($data, WorkflowModel::class, 'json');

        $data = $this->serializer->serialize($workflow, 'json');
        $this->logger->info("[WebhookManager] reserialized workflow", ['data' => $data]);

        if (!$workflow->isValid()) {
            $this->logger->info("[WebhookManager] Error: Workflow invalid! | " . $workflow->isValid() . " | " . $workflow->getVoucher()->isValid(),
                [
                    'workflow_isValid' => gettype($workflow->isValid()),
                    'voucher_isValid' => (string) $workflow->getVoucher()->isValid(),
                    'documentType_id' => $workflow->getVoucher()->getDocumentType()->getId(),
                    'documentType_name' => $workflow->getVoucher()->getDocumentType()->getName(),
                    'documentDate' => $workflow->getVoucher()->getDocumentDate()->format("Y-m-s H:i:s"),
                ]
            );
        }

        return $workflow;
    }

    private function setupSerializer()
    {
        $normalizers = [
            new GetSetMethodNormalizer(
                null,
                new CamelCaseToSnakeCaseNameConverter(),
                new WebhookPropertyTypeExtractor()
            ),
            new ArrayDenormalizer(),
        ];
        $encoders = [new JsonEncoder()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }
}