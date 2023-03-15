<?php

namespace Liondeer\Framework\D3\Model\UserManagement;

use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class MemberModel
{
    private string $id;
    private string $type;
    private array $_links;

    public function __construct($data = null)
    {
        if (null != $data) {
            $this->deserialize($data);
        }
    }

    private function deserialize(string $data): self
    {
        $normalizers = [
            new ArrayDenormalizer(),
            new ObjectNormalizer(propertyTypeExtractor: new ReflectionExtractor())
        ];
        $encoders = [new JsonEncoder()];

        $serializer = new Serializer($normalizers, $encoders);
        $serializer->deserialize($data, GroupModel::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $this]);

        return new $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getLinks(): array
    {
        return $this->_links;
    }

    public function setLinks(array $links): void
    {
        $this->_links = $links;
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
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }
}