<?php


namespace Liondeer\Framework\Model;

use JetBrains\PhpStorm\ArrayShape;
use Liondeer\Framework\Model\DmsExtensionActivationConditionModel;
use Symfony\Contracts\Translation\TranslatorInterface;

class DmsExtensionModel
{
    // DMSObject Context Values
    const CONTEXT_OBJECT_LIST = 'DmsObjectListContextAction';
    const CONTEXT_OBJECT_DETAIL = 'DmsObjectDetailsContextAction';

    // DMSObject Properties
    const PROPERTY_D3_USER_ID = '{user.d3.group_id}';
    const PROPERTY_IDP_USER_ID = '{user.idp.group_id}';
    const PROPERTY_REPOSITORY_ID = '{repository.id}';
    const PROPERTY_DOCUMENT_ID = '{dmsobject.property_document_id}';
    const PROPERTY_EDITOR = '{dmsobject.property_editor}';
    const PROPERTY_OWNER = '{dmsobject.property_owner}';
    const PROPERTY_FILENAME = '{dmsobject.property_filename}';
    const PROPERTY_FILETYPE = '{dmsobject.property_filetype}';
    const PROPERTY_DOCUMENT_NUMBER = '{dmsobject.property_document_number}';
    const PROPERTY_CREATION_DATE = '{dmsobject.property_creation_date}';
    const PROPERTY_SIZE = '{dmsobject.property_size}';
    const PROPERTY_OBJECT_STATE = '{dmsobject.property_state}';
    const PROPERTY_VARIANT_NUMBER = '{dmsobject.property_variant_number}';
    const PROPERTY_ACCESS_DATE = '{dmsobject.property_access_date}';
    const PROPERTY_REMARK = '{dmsobject.property_remark}';
    const PROPERTY_LAST_ALTERATION_DATE = '{dmsobject.property_last_alteration_date}';
    const PROPERTY_CAPTION = '{dmsobject.property_caption}';
    const PROPERTY_CATEGORY = '{dmsobject.property_category}';
    const PROPERTY_CATEGORY_UUID = '{dmsobject.property_category_uuid}';
    const PROPERTY_COLORCODE = '{dmsobject.property_colorcode}';
    const PROPERTY_DOCUMENT_CLASS = '{dmsobject.property_document_class}';
    const PROPERTY_DISPLAY_VERSION_ID = '{dmsobject.property_display_version_id}';
    const PROPERTY_OBJECT_TYPE = '{dmsobject.type}';
    const PROPERTY_ID = '{dmsobject.%s}';
    const PROPERTY_FIELDPOSITION = '{dmsobject.fieldposition.%s}';
    const PROPERTY_SELF_URL = '{dmsobject.self_url_relative}';
    const PROPERTY_MAIN_CONTENT_TYPE = '{dmsobject.mainblob.content_type}';
    const PROPERTY_MAIN_CONTENT_URL = '{dmsobject.mainblob.content_url_relative}';
    const PROPERTY_MAIN_ID = '{dmsobject.mainblob.id}';
    const PROPERTY_DEPENDENT_BLOBS = '{dmsobject.dependentblobs}';
    const PROPERTY_DEPENDENT_BLOB_ID_URL = '{dmsobject.dependentblob.ID.content_url_relative}';

    //possible Values of PROPERTY_OBJECT_TYPE
    const OBJECT_TYPE_DOCUMENT = 'Document';
    const OBJECT_TYPE_FOLDER = 'Folder';

    //possible Values of PROPERTY_OBJECT_STATE
    const OBJECT_STATE_ARCHIVED = 'Archived';
    const OBJECT_STATE_VERIFICATION = 'VerificationInProgress';
    const OBJECT_STATE_PROCESSING = 'Processing';
    const OBJECT_STATE_RELEASED = 'Released';

    private string $id;
    /** @var DmsExtensionActivationConditionModel[] */
    private array $activationConditions = [];
    private string $textKey;
    private string $context;
    private string $url;
    private string $icon;
    private array $languages = ['de'];

    public function __construct(private TranslatorInterface $translator) { }

    #[ArrayShape([
        'id' => "string",
        'activationConditions' => "array",
        'captions' => "array",
        'context' => "string",
        'uriTemplate' => "string",
        'iconUri' => "string"
    ])]
    public function getConfig(): array
    {
        $activationConditions = [];
        foreach ($this->activationConditions as $activationCondition) {
            array_push($activationConditions, $activationCondition->getConfig());
        }

        $captions = [];
        foreach ($this->languages as $language) {
            $caption = [
                'culture' => $language,
                'caption' => $this->translator->trans($this->textKey, [], null, $language)
            ];

            array_push($captions, $caption);
        }

        return [
            'id' => $this->id,
            'activationConditions' => $activationConditions,
            'captions' => $captions,
            'context' => $this->context,
            'uriTemplate' => $this->url,
            'iconUri' => $this->icon
        ];
    }

    public function setContext(string $context): self
    {
        $this->context = $context;

        return $this;
    }

    public function addActivationCondition(DmsExtensionActivationConditionModel $activationConditionModel): self
    {
        array_push($this->activationConditions, $activationConditionModel);

        return $this;
    }

    public function addLanguage(string $language): self
    {
        array_push($this->languages, $language);

        return $this;
    }

    public function setUrl(string $url): self
    {
        $this->url = urldecode($url);

        return $this;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function setTextKey(string $textKey): self
    {
        $this->textKey = $textKey;

        return $this;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getProperties(): array
    {
        $outputClass = new \ReflectionClass($this);
        $allConstants = $outputClass->getConstants();

        return array_filter($allConstants, function ($key) {
            return str_starts_with($key, 'PROPERTY_');
        }, ARRAY_FILTER_USE_KEY);
    }
}