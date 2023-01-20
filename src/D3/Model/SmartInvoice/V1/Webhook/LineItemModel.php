<?php

namespace Liondeer\Framework\D3\Model\SmartInvoice\V1\Webhook;

use Liondeer\SmartInvoice\Model\V1\CostCenterModel;
use Liondeer\SmartInvoice\Model\V1\CostUnitModel;
use Liondeer\SmartInvoice\Model\V1\GlAccountModel;
use Liondeer\SmartInvoice\Model\V1\TaxCodeModel;

class LineItemModel
{
    private ?string $internalId = null;
    private ?int $lineNo = null;
    private ?bool $verified = null;

    private ?AssigneeModel $verifier = null;
    private ?AssigneeModel $verifiedBy = null;
    //private ?AssigneeModel $verified_as_delegate_of = null; TODO Typ erfragen
    private ?\DateTime $verifiedAt = null;

    private ?GlAccountModel $glAccount = null;
    private ?CostCenterModel $costCenter = null;
    private ?CostUnitModel $costUnit = null;

    private ?string $netAmount = null;
    private ?string $grossAmount = null;
    private ?string $payAmount = null;
    private ?string $vatAmount = null;
    private ?TaxCodeModel $taxCode = null;

    private ?string $orderNumber = null;
    private ?int $orderLine = null;
    private ?string $orderId = null;
    private ?string $orderLineId = null;

    private ?QuantityModel $quantity = null;
    private ?string $unit = null;
    private ?string $description = null;
    private ?string $itemNumber = null;
//    private ?float $unit_price = null; // TODO Typ erfragen!
//    private ?float $price_unit = null; // TODO Typ erfragen!
    private ?string $discountAbsolute = null;
    private ?string $discountPerUnit = null;
    private ?string $discountPercent = null;
    private ?string $discount2Percent = null;
    private ?string $discount3Percent = null;
    private ?string $discount4Percent = null;
    private ?string $discount5Percent = null;

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
//    private ?object $procurement_category = null;  // TODO Typ erfragen!

    /**
     * @return string|null
     */
    public function getInternalId(): ?string
    {
        return $this->internalId;
    }

    /**
     * @param string|null $internalId
     * @return LineItemModel
     */
    public function setInternalId(?string $internalId): LineItemModel
    {
        $this->internalId = $internalId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getLineNo(): ?int
    {
        return $this->lineNo;
    }

    /**
     * @param int|null $lineNo
     * @return LineItemModel
     */
    public function setLineNo(?int $lineNo): LineItemModel
    {
        $this->lineNo = $lineNo;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getVerified(): ?bool
    {
        return $this->verified;
    }

    /**
     * @param bool|null $verified
     * @return LineItemModel
     */
    public function setVerified(?bool $verified): LineItemModel
    {
        $this->verified = $verified;
        return $this;
    }

    /**
     * @return AssigneeModel|null
     */
    public function getVerifier(): ?AssigneeModel
    {
        return $this->verifier;
    }

    /**
     * @param AssigneeModel|null $verifier
     * @return LineItemModel
     */
    public function setVerifier(?AssigneeModel $verifier): LineItemModel
    {
        $this->verifier = $verifier;
        return $this;
    }

    /**
     * @return AssigneeModel|null
     */
    public function getVerifiedBy(): ?AssigneeModel
    {
        return $this->verifiedBy;
    }

    /**
     * @param AssigneeModel|null $verifiedBy
     * @return LineItemModel
     */
    public function setVerifiedBy(?AssigneeModel $verifiedBy): LineItemModel
    {
        $this->verifiedBy = $verifiedBy;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getVerifiedAt(): ?\DateTime
    {
        return $this->verifiedAt;
    }

    /**
     * @param \DateTime|string|null $verifiedAt
     * @return LineItemModel
     */
    public function setVerifiedAt(\DateTime|string|null $verifiedAt): LineItemModel
    {
        if (is_string($verifiedAt)) {
            $this->verifiedAt = new \DateTime($verifiedAt);
        } else {
            $this->verifiedAt = $verifiedAt;
        }
        return $this;
    }

    /**
     * @return GlAccountModel|null
     */
    public function getGlAccount(): ?GlAccountModel
    {
        return $this->glAccount;
    }

    /**
     * @param GlAccountModel|null $glAccount
     * @return LineItemModel
     */
    public function setGlAccount(?GlAccountModel $glAccount): LineItemModel
    {
        $this->glAccount = $glAccount;
        return $this;
    }

    /**
     * @return CostCenterModel|null
     */
    public function getCostCenter(): ?CostCenterModel
    {
        return $this->costCenter;
    }

    /**
     * @param CostCenterModel|null $costCenter
     * @return LineItemModel
     */
    public function setCostCenter(?CostCenterModel $costCenter): LineItemModel
    {
        $this->costCenter = $costCenter;
        return $this;
    }

    /**
     * @return CostUnitModel|null
     */
    public function getCostUnit(): ?CostUnitModel
    {
        return $this->costUnit;
    }

    /**
     * @param CostUnitModel|null $costUnit
     * @return LineItemModel
     */
    public function setCostUnit(?CostUnitModel $costUnit): LineItemModel
    {
        $this->costUnit = $costUnit;
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
     * @return LineItemModel
     */
    public function setNetAmount(?string $netAmount): LineItemModel
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
     * @return LineItemModel
     */
    public function setGrossAmount(?string $grossAmount): LineItemModel
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
     * @return LineItemModel
     */
    public function setPayAmount(?string $payAmount): LineItemModel
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
     * @return LineItemModel
     */
    public function setVatAmount(?string $vatAmount): LineItemModel
    {
        $this->vatAmount = $vatAmount;
        return $this;
    }

    /**
     * @return TaxCodeModel|null
     */
    public function getTaxCode(): ?TaxCodeModel
    {
        return $this->taxCode;
    }

    /**
     * @param TaxCodeModel|null $taxCode
     * @return LineItemModel
     */
    public function setTaxCode(?TaxCodeModel $taxCode): LineItemModel
    {
        $this->taxCode = $taxCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOrderNumber(): ?string
    {
        return $this->orderNumber;
    }

    /**
     * @param string|null $orderNumber
     * @return LineItemModel
     */
    public function setOrderNumber(?string $orderNumber): LineItemModel
    {
        $this->orderNumber = $orderNumber;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getOrderLine(): ?int
    {
        return $this->orderLine;
    }

    /**
     * @param int|null $orderLine
     * @return LineItemModel
     */
    public function setOrderLine(?int $orderLine): LineItemModel
    {
        $this->orderLine = $orderLine;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    /**
     * @param string|null $orderId
     * @return LineItemModel
     */
    public function setOrderId(?string $orderId): LineItemModel
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOrderLineId(): ?string
    {
        return $this->orderLineId;
    }

    /**
     * @param string|null $orderLineId
     * @return LineItemModel
     */
    public function setOrderLineId(?string $orderLineId): LineItemModel
    {
        $this->orderLineId = $orderLineId;
        return $this;
    }

    /**
     * @return QuantityModel|null
     */
    public function getQuantity(): ?QuantityModel
    {
        return $this->quantity;
    }

    /**
     * @param QuantityModel|null $quantity
     * @return LineItemModel
     */
    public function setQuantity(?QuantityModel $quantity): LineItemModel
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUnit(): ?string
    {
        return $this->unit;
    }

    /**
     * @param string|null $unit
     * @return LineItemModel
     */
    public function setUnit(?string $unit): LineItemModel
    {
        $this->unit = $unit;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return LineItemModel
     */
    public function setDescription(?string $description): LineItemModel
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getItemNumber(): ?string
    {
        return $this->itemNumber;
    }

    /**
     * @param string|null $itemNumber
     * @return LineItemModel
     */
    public function setItemNumber(?string $itemNumber): LineItemModel
    {
        $this->itemNumber = $itemNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDiscountAbsolute(): ?string
    {
        return $this->discountAbsolute;
    }

    /**
     * @param string|null $discountAbsolute
     * @return LineItemModel
     */
    public function setDiscountAbsolute(?string $discountAbsolute): LineItemModel
    {
        $this->discountAbsolute = $discountAbsolute;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDiscountPerUnit(): ?string
    {
        return $this->discountPerUnit;
    }

    /**
     * @param string|null $discountPerUnit
     * @return LineItemModel
     */
    public function setDiscountPerUnit(?string $discountPerUnit): LineItemModel
    {
        $this->discountPerUnit = $discountPerUnit;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDiscountPercent(): ?string
    {
        return $this->discountPercent;
    }

    /**
     * @param string|null $discountPercent
     * @return LineItemModel
     */
    public function setDiscountPercent(?string $discountPercent): LineItemModel
    {
        $this->discountPercent = $discountPercent;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDiscount2Percent(): ?string
    {
        return $this->discount2Percent;
    }

    /**
     * @param string|null $discount2Percent
     * @return LineItemModel
     */
    public function setDiscount2Percent(?string $discount2Percent): LineItemModel
    {
        $this->discount2Percent = $discount2Percent;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDiscount3Percent(): ?string
    {
        return $this->discount3Percent;
    }

    /**
     * @param string|null $discount3Percent
     * @return LineItemModel
     */
    public function setDiscount3Percent(?string $discount3Percent): LineItemModel
    {
        $this->discount3Percent = $discount3Percent;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDiscount4Percent(): ?string
    {
        return $this->discount4Percent;
    }

    /**
     * @param string|null $discount4Percent
     * @return LineItemModel
     */
    public function setDiscount4Percent(?string $discount4Percent): LineItemModel
    {
        $this->discount4Percent = $discount4Percent;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDiscount5Percent(): ?string
    {
        return $this->discount5Percent;
    }

    /**
     * @param string|null $discount5Percent
     * @return LineItemModel
     */
    public function setDiscount5Percent(?string $discount5Percent): LineItemModel
    {
        $this->discount5Percent = $discount5Percent;
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
     * @return LineItemModel
     */
    public function setCustom1(?string $custom1): LineItemModel
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
     * @return LineItemModel
     */
    public function setCustom2(?string $custom2): LineItemModel
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
     * @return LineItemModel
     */
    public function setCustom3(?string $custom3): LineItemModel
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
     * @return LineItemModel
     */
    public function setCustom4(?string $custom4): LineItemModel
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
     * @return LineItemModel
     */
    public function setCustom5(?string $custom5): LineItemModel
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
     * @return LineItemModel
     */
    public function setCustom6(?string $custom6): LineItemModel
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
     * @return LineItemModel
     */
    public function setCustom7(?string $custom7): LineItemModel
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
     * @return LineItemModel
     */
    public function setCustom8(?string $custom8): LineItemModel
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
     * @return LineItemModel
     */
    public function setCustom9(?string $custom9): LineItemModel
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
     * @return LineItemModel
     */
    public function setCustom10(?string $custom10): LineItemModel
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
     * @return LineItemModel
     */
    public function setCustom11(?string $custom11): LineItemModel
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
     * @return LineItemModel
     */
    public function setCustom12(?string $custom12): LineItemModel
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
     * @return LineItemModel
     */
    public function setCustom13(?string $custom13): LineItemModel
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
     * @return LineItemModel
     */
    public function setCustom14(?string $custom14): LineItemModel
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
     * @return LineItemModel
     */
    public function setCustom15(?string $custom15): LineItemModel
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
     * @return LineItemModel
     */
    public function setCustom16(?string $custom16): LineItemModel
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
     * @return LineItemModel
     */
    public function setCustom17(?string $custom17): LineItemModel
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
     * @return LineItemModel
     */
    public function setCustom18(?string $custom18): LineItemModel
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
     * @return LineItemModel
     */
    public function setCustom19(?string $custom19): LineItemModel
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
     * @return LineItemModel
     */
    public function setCustom20(?string $custom20): LineItemModel
    {
        $this->custom20 = $custom20;
        return $this;
    }
}