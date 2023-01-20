<?php

namespace Liondeer\Framework\D3\Manager\SmartInvoice;

use Liondeer\Framework\D3\Model\SmartInvoice\V1\CompanyModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\CostCenterModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\CostUnitModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\CurrencyModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\DocumentTypeModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\GlAccountModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\PaymentTermsModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\TaxCodeModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\VendorModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\Webhook\AssigneeModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\Webhook\ConnectionModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\Webhook\LineItemModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\Webhook\QuantityModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\Webhook\StepModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\Webhook\VoucherModel;
use Liondeer\Framework\D3\Model\SmartInvoice\V1\Webhook\WorkflowModel;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\PropertyInfo\Type;

class WebhookPropertyTypeExtractor implements PropertyTypeExtractorInterface
{
    public function getTypes($class, $property, array $context = array())
    {
        if (is_a($class, WorkflowModel::class, true)) {
            switch ($property) {
                case 'voucher':
                    return [new Type(Type::BUILTIN_TYPE_OBJECT, true, VoucherModel::class)];
                case 'step':
                    return [new Type(Type::BUILTIN_TYPE_OBJECT, true, StepModel::class)];
                case 'connection':
                    return [new Type(Type::BUILTIN_TYPE_OBJECT, true, ConnectionModel::class)];
            }
        }

        if (is_a($class, VoucherModel::class, true)) {
            switch ($property) {
                case 'company':
                    return [new Type(Type::BUILTIN_TYPE_OBJECT, true, CompanyModel::class)];
                case 'vendor':
                    return [new Type(Type::BUILTIN_TYPE_OBJECT, true, VendorModel::class)];
                case 'currency':
                    return [new Type(Type::BUILTIN_TYPE_OBJECT, true, CurrencyModel::class)];
                case 'documentType':
                    return [new Type(Type::BUILTIN_TYPE_OBJECT, true, DocumentTypeModel::class)];
                case 'paymentTerms':
                    return [new Type(Type::BUILTIN_TYPE_OBJECT, true, PaymentTermsModel::class)];
                case 'lineItems':
                    return [new Type(Type::BUILTIN_TYPE_OBJECT, true, LineItemModel::class.'[]')];
            }
        }

        if (is_a($class, LineItemModel::class, true)) {
            switch ($property) {
                case 'verifier':
                case 'verifiedBy':
                //case 'verifiedAsDelegateOf':
                    return [new Type(Type::BUILTIN_TYPE_OBJECT, true, AssigneeModel::class)];
                case 'glAccount':
                    return [new Type(Type::BUILTIN_TYPE_OBJECT, true, GlAccountModel::class)];
                case 'costCenter':
                    return [new Type(Type::BUILTIN_TYPE_OBJECT, true, CostCenterModel::class)];
                case 'costUnit':
                    return [new Type(Type::BUILTIN_TYPE_OBJECT, true, CostUnitModel::class)];
                case 'taxCode':
                    return [new Type(Type::BUILTIN_TYPE_OBJECT, true, TaxCodeModel::class)];
                case 'quantity':
                    return [new Type(Type::BUILTIN_TYPE_OBJECT, true, QuantityModel::class)];
            }
        }

        if (is_a($class, ConnectionModel::class, true)) {
            switch ($property) {
                case 'fromStep':
                case 'toStep':
                    return [new Type(Type::BUILTIN_TYPE_OBJECT, true, StepModel::class)];
            }
        }

        return null;
    }
}