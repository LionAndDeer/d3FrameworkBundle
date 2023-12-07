<?php

namespace Liondeer\Framework\D3\Manager\Sign;

use App\Entity\Tenant;
use Liondeer\Framework\D3\Proxy\Sign\Documents;

class DocumentManager
{
    private $counter = 0;

    public function __construct(
        private Documents           $documentsProxy
    )
    {
    }


    public function uploadDocumentToSign(string $baseUri, string $authToken, $documentStream, string $filename)
    {
        // Anlegen des SignObjekts
        $documentId = $this->documentsProxy->postDoucments(
            $baseUri,
            $authToken,
            $filename,
        );

        if (!$documentId) {
            //TODO: ErrorHandling SignObjekt wurde nicht angelegt
        }

        // Abrufen der Informationen des SignObjekts
        $documentModel = $this->documentsProxy->getDocumentFromId(
            $baseUri,
            $authToken,
            $documentId
        );

        $uploadLink = ($documentModel->getLinks())['uploadLink']['href'];

        // Upload des Dokuments anhand des UploadLinks des SignObjekts
        $uploadResponse = $this->documentsProxy->uploadDocumentPerUploadLink(
            $uploadLink,
            $documentStream,
        );
        if (!$uploadResponse) {
            //TODO: ErrorHandling PDF wurde nicht hochgeladen
        }

        // Update des SignObjekts nach Upload des Dokuments mit dem EventType 'uploaded'
        $updateDocumentResponse = $this->documentsProxy->updateDocumentEvent(
            $baseUri,
            $authToken,
            $documentId,
            'uploaded'
        );

        if (!$updateDocumentResponse) {
            //TODO: ErrorHandling SignObjekt wurde nicht geupdated
        }

        // Nochmmaliges Abrufen der Informationen des SignObjekts
        $documentModel = $this->documentsProxy->getDocumentFromId(
            $baseUri,
            $authToken,
            $documentId
        );

        // Kontrolle ob der Upload wirklich Stattgefunden hat
        if ($documentModel->getUploadDate()) {
            return $documentModel;
        }

        //TODO sauberes Fehlerhandling

        if ($this->counter < 3) {
            $this->counter++;
            $this->uploadDocumentToSign($baseUri, $authToken, $documentStream, $filename);
        }
    }
}