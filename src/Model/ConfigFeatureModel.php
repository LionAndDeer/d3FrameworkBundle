<?php

namespace Liondeer\Framework\Model;


use JetBrains\PhpStorm\ArrayShape;
use Symfony\Contracts\Translation\TranslatorInterface;

class ConfigFeatureModel
{
    private string $name;
    private string $caption;
    private string $description;
    private string $href;
    private array $keywords = [];
    private bool $configurationState;
    private AbstractConfigFeatureHeadlineModel $configFeatureHeadlineModel;
    private array $authorizedRoles = [];
    private bool $visible = true;

    public function __construct(
        private TranslatorInterface $translator,
        private int $order = 1
    ) {
        //Name der konkreten aufrufenden Klasse auslesen - zB: BraveElephantConfigFeatureController
        $this->name = debug_backtrace()[2]['class'] . '_ConfigFeatureModel';
    }

    #[ArrayShape([
        "caption" => "string",
        "description" => "string",
        "href" => "string",
        "keywords" => "array",
        "configurationState" => "int"
    ])]
    public function getConfig(): array
    {
        return
            [
                "caption" => $this->translator->trans($this->caption),
                "description" => $this->translator->trans($this->description),
                "href" => $this->href,
                "keywords" => $this->keywords,
                "configurationState" => $this->configurationState ? 1 : 0,
            ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getConfigFeatureHeadlineModel(): AbstractConfigFeatureHeadlineModel
    {
        return $this->configFeatureHeadlineModel;
    }

    public function setConfigFeatureHeadlineModel(AbstractConfigFeatureHeadlineModel $configFeatureHeadlineModel
    ): ConfigFeatureModel {
        if (!empty($this->configFeatureHeadlineModel)) {
            $this->configFeatureHeadlineModel->removeMenuItem($this);
        }
        $this->configFeatureHeadlineModel = $configFeatureHeadlineModel;
        $configFeatureHeadlineModel->addMenuItem($this);

        return $this;
    }

    public function setCaption(string $caption): ConfigFeatureModel
    {
        $this->caption = $caption;

        return $this;
    }

    public function setDescription(string $description): ConfigFeatureModel
    {
        $this->description = $description;

        return $this;
    }

    public function setHref(string $href): ConfigFeatureModel
    {
        $this->href = $href;

        return $this;
    }

    public function setKeywords(array $keywords): ConfigFeatureModel
    {
        $this->keywords = $keywords;

        return $this;
    }

    public function setConfigurationState(bool $configurationState): ConfigFeatureModel
    {
        $this->configurationState = $configurationState;

        return $this;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function getAuthorizedRoles(): array
    {
        return $this->authorizedRoles;
    }

    public function setAuthorizedRoles(array $authorizedRoles): self
    {
        $this->authorizedRoles = $authorizedRoles;

        return $this;
    }

    public function setVisible(bool $isRegistered): self
    {
        $this->visible = $isRegistered;

        return $this;
    }

    public function isVisible(): bool
    {
        return $this->visible;
    }
}