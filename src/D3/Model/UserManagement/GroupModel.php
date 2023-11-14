<?php

namespace Liondeer\Framework\D3\Model\UserManagement;

use Liondeer\Framework\Model\MemberModel;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class GroupModel
{
    private string $id;
    private string $name;
    private string $infoText;
    /** @var MemberModel[] $members */
    private array $members;
    private array $_links;

    public function __construct(string $data = null)
    {
        $normalizers = [
            new ArrayDenormalizer(),
            new ObjectNormalizer(propertyTypeExtractor: new ReflectionExtractor())
        ];
        $encoders = [new JsonEncoder()];

        $this->serializer = new Serializer($normalizers, $encoders);
        if (!empty($data)) {
            $this->deserialize($data);
        }
    }

    private function deserialize(string $data): self
    {
        $this->serializer->deserialize($data, GroupModel::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $this]);

        return new $this;
    }

    public function serialize(string $format)
    {
        return $this->serializer->serialize($this, $format);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return GroupModel
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return GroupModel
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getInfoText(): string
    {
        return $this->infoText;
    }

    /**
     * @param string $infoText
     *
     * @return GroupModel
     */
    public function setInfoText(string $infoText): self
    {
        $this->infoText = $infoText;

        return $this;
    }

    /**
     * @return array
     */
    public function getMembers(): array
    {
        return $this->members;
    }

    /**
     * @param array $members
     *
     * @return GroupModel
     */
    public function setMembers(array $members): self
    {
        $this->members = $members;

        return $this;
    }

    public function getLinks(): array
    {
        return $this->_links;
    }

    public function setLinks(array $links): self
    {
        $this->_links = $links;

        return $this;
    }
}