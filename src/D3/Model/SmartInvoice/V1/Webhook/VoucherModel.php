<?php

namespace Liondeer\Framework\D3\Model\SmartInvoice\V1\Webhook;

use Liondeer\SmartInvoice\Model\V1\CompanyModel;
use Liondeer\SmartInvoice\Model\V1\CurrencyModel;
use Liondeer\SmartInvoice\Model\V1\DocumentTypeModel;
use Liondeer\SmartInvoice\Model\V1\PaymentTermsModel;
use Liondeer\SmartInvoice\Model\V1\VendorModel;

class VoucherModel
{
    private ?string $docId = null;

    private ?CompanyModel $company = null;
    private ?VendorModel $vendor = null;
    private ?CurrencyModel $currency = null;

    private ?string $netAmount = null;
    private ?string $grossAmount = null;
    private ?string $payAmount = null;
    private ?string $vatAmount = null;
    private ?\DateTime $documentDate = null;
    private ?string $internalNumber = null;
    private ?string $externalNumber = null;
    private ?\DateTime $paymentDate = null;
    private ?\DateTime $dateOfSupply = null;
    private ?bool $financially_correct = null;

    private ?DocumentTypeModel $documentType = null;
    private ?PaymentTermsModel $paymentTerms = null;

    private ?string $postingPeriod = null;
    private ?\DateTime $posting_date = null;
    private ?string $postingText = null;
    private ?string $barcode = null;
    private ?string $custom1 = null;
    private ?string $custom2 = null;
    private ?string $custom3 = null;
    private ?string $custom4 = null;
    private ?string $custom5 = null;
    private ?string $custom6 = null;
    private ?string $custom7 = null;
    private ?string $custom8 = null;
    private ?string $custom9 = null;
    private ?string $custom10 = null;
    private ?string $custom11 = null;
    private ?string $custom12 = null;
    private ?string $custom13 = null;
    private ?string $custom14 = null;
    private ?string $custom15 = null;
    private ?string $custom16 = null;
    private ?string $custom17 = null;
    private ?string $custom18 = null;
    private ?string $custom19 = null;
    private ?string $custom20 = null;

    /** @var LineItemModel[]|null */
    private ?array $lineItems = null;

    public function isValid(): bool
    {
        return (
            !empty($this->documentType)
            && !empty($this->documentDate)
        );
    }

    /**
     * @return LineItemModel[]|null
     */
    public function getLineItems(): ?array
    {
        return $this->lineItems;
    }

    /**
     * @param LineItemModel[]|null $lineItems
     * @return VoucherModel
     */
    public function setLineItems(?array $lineItems): VoucherModel
    {
        $this->lineItems = $lineItems;
        return $this;
    }

    public function getDocId(): ?string
    {
        return $this->docId;
    }


    public function setDocId(?string $docId): VoucherModel
    {
        $this->docId = $docId;
        return $this;
    }

    /**
     * @return CompanyModel|null
     */
    public function getCompany(): ?CompanyModel
    {
        return $this->company;
    }

    /**
     * @param CompanyModel|null $company
     * @return VoucherModel
     */
    public function setCompany(?CompanyModel $company): VoucherModel
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return VendorModel|null
     */
    public function getVendor(): ?VendorModel
    {
        return $this->vendor;
    }

    /**
     * @param VendorModel|null $vendor
     * @return VoucherModel
     */
    public function setVendor(?VendorModel $vendor): VoucherModel
    {
        $this->vendor = $vendor;
        return $this;
    }

    /**
     * @return CurrencyModel|null
     */
    public function getCurrency(): ?CurrencyModel
    {
        return $this->currency;
    }

    /**
     * @param CurrencyModel|null $currency
     * @return VoucherModel
     */
    public function setCurrency(?CurrencyModel $currency): VoucherModel
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNetAmount(): ?string
    {
        return $this->netAmount;
    }

    /**
     * @param string|null $netAmount
     * @return VoucherModel
     */
    public function setNetAmount(string|null $netAmount): VoucherModel
    {
        $this->netAmount = $netAmount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGrossAmount(): ?string
    {
        return $this->grossAmount;
    }

    /**
     * @param string|null $grossAmount
     * @return VoucherModel
     */
    public function setGrossAmount(?string $grossAmount): VoucherModel
    {
        $this->grossAmount = $grossAmount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPayAmount(): ?string
    {
        return $this->payAmount;
    }

    /**
     * @param string|null $payAmount
     * @return VoucherModel
     */
    public function setPayAmount(?string $payAmount): VoucherModel
    {
        $this->payAmount = $payAmount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVatAmount(): ?string
    {
        return $this->vatAmount;
    }

    /**
     * @param string|null $vatAmount
     * @return VoucherModel
     */
    public function setVatAmount(?string $vatAmount): VoucherModel
    {
        $this->vatAmount = $vatAmount;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDocumentDate(): ?\DateTime
    {
        return $this->documentDate;
    }

    /**
     * @param \DateTime|string|null $documentDate
     * @return VoucherModel
     */
    public function setDocumentDate(\DateTime|string|null $documentDate): VoucherModel
    {
        if (is_string($documentDate)) {
            $this->documentDate = new \DateTime($documentDate);
        } else {
            $this->documentDate = $documentDate;
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInternalNumber(): ?string
    {
        return $this->internalNumber;
    }

    /**
     * @param string|null $internalNumber
     * @return VoucherModel
     */
    public function setInternalNumber(?string $internalNumber): VoucherModel
    {
        $this->internalNumber = $internalNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getExternalNumber(): ?string
    {
        return $this->externalNumber;
    }

    /**
     * @param string|null $externalNumber
     * @return VoucherModel
     */
    public function setExternalNumber(?string $externalNumber): VoucherModel
    {
        $this->externalNumber = $externalNumber;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getPaymentDate(): ?\DateTime
    {
        return $this->paymentDate;
    }

    /**
     * @param \DateTime|string|null $paymentDate
     * @return VoucherModel
     */
    public function setPaymentDate(\DateTime|string|null $paymentDate): VoucherModel
    {
        if (is_string($paymentDate)) {
            $this->paymentDate = new \DateTime($paymentDate);
        } else {
            $this->paymentDate = $paymentDate;
        }
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateOfSupply(): ?\DateTime
    {
        return $this->dateOfSupply;
    }

    /**
     * @param \DateTime|string|null $dateOfSupply
     * @return VoucherModel
     */
    public function setDateOfSupply(\DateTime|string|null $dateOfSupply): VoucherModel
    {
        if (is_string($dateOfSupply)) {
            $this->dateOfSupply = new \DateTime($dateOfSupply);
        } else {
            $this->dateOfSupply = $dateOfSupply;
        }
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getFinanciallyCorrect(): ?bool
    {
        return $this->financially_correct;
    }

    /**
     * @param bool|null $financially_correct
     * @return VoucherModel
     */
    public function setFinanciallyCorrect(?bool $financially_correct): VoucherModel
    {
        $this->financially_correct = $financially_correct;
        return $this;
    }

    /**
     * @return DocumentTypeModel|null
     */
    public function getDocumentType(): ?DocumentTypeModel
    {
        return $this->documentType;
    }

    /**
     * @param DocumentTypeModel|null $documentType
     * @return VoucherModel
     */
    public function setDocumentType(?DocumentTypeModel $documentType): VoucherModel
    {
        $this->documentType = $documentType;
        return $this;
    }

    /**
     * @return PaymentTermsModel|null
     */
    public function getPaymentTerms(): ?PaymentTermsModel
    {
        return $this->paymentTerms;
    }

    /**
     * @param PaymentTermsModel|null $paymentTerms
     * @return VoucherModel
     */
    public function setPaymentTerms(?PaymentTermsModel $paymentTerms): VoucherModel
    {
        $this->paymentTerms = $paymentTerms;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPostingPeriod(): string|null
    {
        return $this->postingPeriod;
    }

    /**
     * @param string|null $postingPeriod
     * @return VoucherModel
     */
    public function setPostingPeriod(string|null $postingPeriod): VoucherModel
    {
        $this->postingPeriod = $postingPeriod;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getPostingDate(): ?\DateTime
    {
        return $this->posting_date;
    }

    /**
     * @param \DateTime|string|null $posting_date
     * @return VoucherModel
     */
    public function setPostingDate(\DateTime|string|null $posting_date): VoucherModel
    {
        if (is_string($posting_date)) {
            $this->posting_date = new \DateTime($posting_date);
        } else {
            $this->posting_date = $posting_date;
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPostingText(): ?string
    {
        return $this->postingText;
    }

    /**
     * @param string|null $postingText
     * @return VoucherModel
     */
    public function setPostingText(?string $postingText): VoucherModel
    {
        $this->postingText = $postingText;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    /**
     * @param string|null $barcode
     * @return VoucherModel
     */
    public function setBarcode(?string $barcode): VoucherModel
    {
        $this->barcode = $barcode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustom1(): ?string
    {
        return $this->custom1;
    }

    /**
     * @param string|null $custom1
     * @return VoucherModel
     */
    public function setCustom1(?string $custom1): VoucherModel
    {
        $this->custom1 = $custom1;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustom2(): ?string
    {
        return $this->custom2;
    }

    /**
     * @param string|null $custom2
     * @return VoucherModel
     */
    public function setCustom2(?string $custom2): VoucherModel
    {
        $this->custom2 = $custom2;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustom3(): ?string
    {
        return $this->custom3;
    }

    /**
     * @param string|null $custom3
     * @return VoucherModel
     */
    public function setCustom3(?string $custom3): VoucherModel
    {
        $this->custom3 = $custom3;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustom4(): ?string
    {
        return $this->custom4;
    }

    /**
     * @param string|null $custom4
     * @return VoucherModel
     */
    public function setCustom4(?string $custom4): VoucherModel
    {
        $this->custom4 = $custom4;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustom5(): ?string
    {
        return $this->custom5;
    }

    /**
     * @param string|null $custom5
     * @return VoucherModel
     */
    public function setCustom5(?string $custom5): VoucherModel
    {
        $this->custom5 = $custom5;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustom6(): ?string
    {
        return $this->custom6;
    }

    /**
     * @param string|null $custom6
     * @return VoucherModel
     */
    public function setCustom6(?string $custom6): VoucherModel
    {
        $this->custom6 = $custom6;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustom7(): ?string
    {
        return $this->custom7;
    }

    /**
     * @param string|null $custom7
     * @return VoucherModel
     */
    public function setCustom7(?string $custom7): VoucherModel
    {
        $this->custom7 = $custom7;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustom8(): ?string
    {
        return $this->custom8;
    }

    /**
     * @param string|null $custom8
     * @return VoucherModel
     */
    public function setCustom8(?string $custom8): VoucherModel
    {
        $this->custom8 = $custom8;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustom9(): ?string
    {
        return $this->custom9;
    }

    /**
     * @param string|null $custom9
     * @return VoucherModel
     */
    public function setCustom9(?string $custom9): VoucherModel
    {
        $this->custom9 = $custom9;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustom10(): ?string
    {
        return $this->custom10;
    }

    /**
     * @param string|null $custom10
     * @return VoucherModel
     */
    public function setCustom10(?string $custom10): VoucherModel
    {
        $this->custom10 = $custom10;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustom11(): ?string
    {
        return $this->custom11;
    }

    /**
     * @param string|null $custom11
     * @return VoucherModel
     */
    public function setCustom11(?string $custom11): VoucherModel
    {
        $this->custom11 = $custom11;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustom12(): ?string
    {
        return $this->custom12;
    }

    /**
     * @param string|null $custom12
     * @return VoucherModel
     */
    public function setCustom12(?string $custom12): VoucherModel
    {
        $this->custom12 = $custom12;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustom13(): ?string
    {
        return $this->custom13;
    }

    /**
     * @param string|null $custom13
     * @return VoucherModel
     */
    public function setCustom13(?string $custom13): VoucherModel
    {
        $this->custom13 = $custom13;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustom14(): ?string
    {
        return $this->custom14;
    }

    /**
     * @param string|null $custom14
     * @return VoucherModel
     */
    public function setCustom14(?string $custom14): VoucherModel
    {
        $this->custom14 = $custom14;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustom15(): ?string
    {
        return $this->custom15;
    }

    /**
     * @param string|null $custom15
     * @return VoucherModel
     */
    public function setCustom15(?string $custom15): VoucherModel
    {
        $this->custom15 = $custom15;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustom16(): ?string
    {
        return $this->custom16;
    }

    /**
     * @param string|null $custom16
     * @return VoucherModel
     */
    public function setCustom16(?string $custom16): VoucherModel
    {
        $this->custom16 = $custom16;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustom17(): ?string
    {
        return $this->custom17;
    }

    /**
     * @param string|null $custom17
     * @return VoucherModel
     */
    public function setCustom17(?string $custom17): VoucherModel
    {
        $this->custom17 = $custom17;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustom18(): ?string
    {
        return $this->custom18;
    }

    /**
     * @param string|null $custom18
     * @return VoucherModel
     */
    public function setCustom18(?string $custom18): VoucherModel
    {
        $this->custom18 = $custom18;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustom19(): ?string
    {
        return $this->custom19;
    }

    /**
     * @param string|null $custom19
     * @return VoucherModel
     */
    public function setCustom19(?string $custom19): VoucherModel
    {
        $this->custom19 = $custom19;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustom20(): ?string
    {
        return $this->custom20;
    }

    /**
     * @param string|null $custom20
     * @return VoucherModel
     */
    public function setCustom20(?string $custom20): VoucherModel
    {
        $this->custom20 = $custom20;
        return $this;
    }
}