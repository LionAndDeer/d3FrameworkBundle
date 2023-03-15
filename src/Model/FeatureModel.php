<?php

namespace Liondeer\Framework\Model;


use JetBrains\PhpStorm\ArrayShape;
use Symfony\Contracts\Translation\TranslatorInterface;

class FeatureModel
{
    private string $url;
    private string $title;
    private string $subtitle;
    private string $iconUri;
    private string $summary;
    private string $description;
    private string $color;
    private int $badgeCount;
    private array $authorizedRoles = [];

    public function __construct(private TranslatorInterface $translator) { }

    #[ArrayShape([
        "url" => "string",
        "title" => "string",
        "subtitle" => "string",
        "iconURI" => "string",
        "summary" => "string",
        "description" => "string",
        "color" => "string",
        "badge" => "int[]"
    ])]
    public function getConfig(): array
    {
        return [
            "url" => $this->url,
            "title" => $this->translator->trans($this->title),
            "subtitle" => $this->translator->trans($this->subtitle),
            "iconURI" => $this->iconUri,
            "summary" => $this->translator->trans($this->summary),
            "description" => $this->translator->trans($this->description),
            "color" => $this->color,
            "badge" => [
                "count" => $this->badgeCount,
            ]
        ];
    }

    public function setUrl(string $url): FeatureModel
    {
        $this->url = $url;

        return $this;
    }

    public function setTitle(string $title): FeatureModel
    {
        $this->title = $title;

        return $this;
    }

    public function setSubtitle(string $subtitle): FeatureModel
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function setIconUri(string $iconUri): FeatureModel
    {
        $this->iconUri = $iconUri;

        return $this;
    }

    public function setSummary(string $summary): FeatureModel
    {
        $this->summary = $summary;

        return $this;
    }

    public function setDescription(string $description): FeatureModel
    {
        $this->description = $description;

        return $this;
    }

    public function setColor(string $color): FeatureModel
    {
        $this->color = $color;

        return $this;
    }

    public function setBadgeCount(int $badgeCount): FeatureModel
    {
        $this->badgeCount = $badgeCount;

        return $this;
    }

    public function getAuthorizedRoles(): array
    {
        return $this->authorizedRoles;
    }

    public function setAuthorizedRoles(array $authorizedRoles): FeatureModel
    {
        $this->authorizedRoles = $authorizedRoles;

        return $this;
    }
}