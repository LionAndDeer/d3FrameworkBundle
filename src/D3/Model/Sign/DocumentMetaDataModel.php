<?php

namespace Liondeer\Framework\D3\Model\Sign;

class DocumentMetaDataModel
{
            /* {
            "_links": {
            "uploadLink": {
            "href": "string"
            },
            "downloadLink": {
            "href": "string"
            }
            },
            "fileName": "string",
            "fileExtension": "string",
            "documentId": "string",
            "uploadDate": "string",
            "signDate": "2023-11-07T10:25:05.555Z",
            "signState": "unsigned",
            "shareData": [
            {
            "userId": "string",
            "signState": "unsigned"
            }
            ],
            "shared": true,
            "processId": "string"
            }*/
    private ?string      $fileName;
    private ?string      $fileExtension;
    private ?string      $documentId;
    private ?string      $uploadDate;
    private ?\DateTime   $signDate;
    private ?string      $signState;
    private ?array       $shareData;
    private ?bool        $shared;
    private ?string      $processId;

    #[SerializedName('_links')]
    private array        $links;

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): DocumentMetaDataModel
    {
        $this->fileName = $fileName;
        return $this;
    }

    public function getFileExtension(): ?string
    {
        return $this->fileExtension;
    }

    public function setFileExtension(?string $fileExtension): DocumentMetaDataModel
    {
        $this->fileExtension = $fileExtension;
        return $this;
    }

    public function getDocumentId(): ?string
    {
        return $this->documentId;
    }

    public function setDocumentId(?string $documentId): DocumentMetaDataModel
    {
        $this->documentId = $documentId;
        return $this;
    }

    public function getUploadDate(): ?string
    {
        return $this->uploadDate;
    }

    public function setUploadDate(?string $uploadDate): DocumentMetaDataModel
    {
        $this->uploadDate = $uploadDate;
        return $this;
    }

    public function getSignDate(): ?\DateTime
    {
        return $this->signDate;
    }

    public function setSignDate(?\DateTime $signDate): DocumentMetaDataModel
    {
        $this->signDate = $signDate;
        return $this;
    }

    public function getSignState(): ?string
    {
        return $this->signState;
    }

    public function setSignState(?string $signState): DocumentMetaDataModel
    {
        $this->signState = $signState;
        return $this;
    }

    public function getShareData(): ?array
    {
        return $this->shareData;
    }

    public function setShareData(?array $shareData): DocumentMetaDataModel
    {
        $this->shareData = $shareData;
        return $this;
    }

    public function getShared(): ?bool
    {
        return $this->shared;
    }

    public function setShared(?bool $shared): DocumentMetaDataModel
    {
        $this->shared = $shared;
        return $this;
    }

    public function getProcessId(): ?string
    {
        return $this->processId;
    }

    public function setProcessId(?string $processId): DocumentMetaDataModel
    {
        $this->processId = $processId;
        return $this;
    }

    public function getLinks(): array
    {
        return $this->links;
    }

    public function setLinks(array $links): DocumentMetaDataModel
    {
        $this->links = $links;
        return $this;
    }
    
}