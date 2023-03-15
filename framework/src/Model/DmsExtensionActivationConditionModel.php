<?php


namespace Liondeer\Framework\Model;


use JetBrains\PhpStorm\ArrayShape;

class DmsExtensionActivationConditionModel
{
    //Property
    const PROPERTY_REPOSITORY_ID = "repository.id";
    const PROPERTY_USERGROUP_D3 = "user.d3.group_id";
    const PROPERTY_USERGROUP_IDP = "user.idp.group_id";
    const PROPERTY_EDITOR = 'dmsobject.property_editor';
    const PROPERTY_OWNER = 'dmsobject.property_owner';
    const PROPERTY_FILENAME = 'dmsobject.property_filename';
    const PROPERTY_FILETYPE = 'dmsobject.property_filetype';
    const PROPERTY_DOCUMENT_NUMBER = 'dmsobject.property_document_number';
    const PROPERTY_CREATION_DATE = 'dmsobject.property_creation_date';
    const PROPERTY_SIZE = 'dmsobject.property_size';
    const PROPERTY_OBJECT_STATE = 'dmsobject.property_state';
    const PROPERTY_VARIANT_NUMBER = 'dmsobject.property_variant_number';
    const PROPERTY_ACCESS_DATE = 'dmsobject.property_access_date';
    const PROPERTY_REMARK = 'dmsobject.property_remark';
    const PROPERTY_LAST_ALTERATION_DATE = 'dmsobject.property_last_alteration_date';
    const PROPERTY_CAPTION = 'dmsobject.property_caption';
    const PROPERTY_CATEGORY = 'dmsobject.property_category';
    const PROPERTY_CATEGORY_UUID = 'dmsobject.property_category_uuid';
    const PROPERTY_COLORCODE = 'dmsobject.property_colorcode';
    const PROPERTY_DOCUMENT_CLASS = 'dmsobject.property_document_class';
    const PROPERTY_DOCUMENT_ID = 'dmsobject.property_document_id';
    const PROPERTY_DISPLAY_VERSION_ID = 'dmsobject.property_display_version_id';
    const PROPERTY_OBJECT_TYPE = 'dmsobject.type';
    const PROPERTY_ID = 'dmsobject.%s';
    const PROPERTY_FIELDPOSITION = 'dmsobject.fieldposition.%s';
    const PROPERTY_SELF_URL = 'dmsobject.self_url_relative';
    const PROPERTY_MAIN_CONTENT_TYPE = 'dmsobject.mainblob.content_type';
    const PROPERTY_MAIN_CONTENT_URL = 'dmsobject.mainblob.content_url_relative';
    const PROPERTY_MAIN_ID = 'dmsobject.mainblob.id';
    const PROPERTY_DEPENDENT_BLOBS = 'dmsobject.dependentblobs';
    const PROPERTY_DEPENDENT_BLOB_ID_URL = 'dmsobject.dependentblob.ID.content_url_relative';

    // Document Type
    const OBJECT_TYPE_DOCUMENT = 'Document';
    const OBJECT_TYPE_FOLDER = 'Folder';

    //possible Values of PROPERTY_OBJECT_STATE
    const OBJECT_STATE_ARCHIVED = 'Archived';
    const OBJECT_STATE_VERIFICATION = 'VerificationInProgress';
    const OBJECT_STATE_PROCESSING = 'Processing';
    const OBJECT_STATE_RELEASED = 'Released';

    //Operator
    const OPERATOR_OR = 'or';
    const OPERATOR_NOT_OR = 'notOr';

    private string $property;
    private string $condition;
    private array $values = [];

    #[ArrayShape(["propertyId" => "string", "operator" => "string", "values" => "array"])]
    public function getConfig(): array
    {
        return [
            "propertyId" => $this->property,
            "operator" => $this->condition,
            "values" => $this->values
        ];
    }

    public function setCondition(string $condition): self
    {
        $this->condition = $condition;

        return $this;
    }

    public function setProperty(string $property): self
    {
        $this->property = $property;

        return $this;
    }

    public function setValues(array $values): self
    {
        $this->values = $values;

        return $this;
    }
}