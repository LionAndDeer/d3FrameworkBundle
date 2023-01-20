<?php

namespace Liondeer\Framework\IdentityProvider;

use App\Manager\PermissionManager;
use App\Security\InterAppUser;
use Exception;
use Liondeer\Framework\Exception\LiondeerD3FrameworkException;
use Liondeer\Framework\Model\UserReponse;
use Liondeer\Framework\Security\User;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class IdentityProviderUserService
{

    private string $bearer;
    private array $credentials;
    private UserReponse $userResponse;

    public function __construct(
        private SerializerInterface $serializer,
        private PermissionManager $permissionManager
    ) {
    }

    /**
     * @throws ClientExceptionInterface
     * @throws LiondeerD3FrameworkException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getCurrentUser($bearerToken, $credentials): User|InterAppUser
    {
        //TODO wenn sessionId schon im cache: request gar nich losschicken
        $httpClient = HttpClient::create();
        try {
            $response = $httpClient->request(
                Request::METHOD_GET,
                $credentials['d3BaseUri'] . '/identityprovider/validate',
                [
                    'headers' => [
                        'Content-Type' => 'application/json; charset=utf-8',
                        'Origin' => $credentials['d3BaseUri'],
                        'Authorization' => 'Bearer ' . $bearerToken
                    ],
                ]
            );

            $this->bearer = $bearerToken;
            $this->credentials = $credentials;
            $this->userResponse = $this->serializer->deserialize($response->getContent(), UserReponse::class, 'json');
            
            if (array_search('Apps', $this->userResponse->getGroups())) {
                return $this->getInterAppuser();
            } else {
                return $this->getD3User();
            }
        } catch (Exception $e) {
            throw new LiondeerD3FrameworkException(
                'Daten des aktuellen Nutzers konnten nicht geladen werden',
                1005
            );
        }
    }

    private function getInterAppuser(): InterAppUser
    {
        $interAppuser = new InterAppUser();
        $interAppuser
            ->setUsername($this->userResponse->getUserName())
            ->setGroups($this->userResponse->getGroups())
            ->setBearerToken($this->bearer)
            ->setBaseUri($this->credentials['d3BaseUri'])
            ->setTenantId($this->credentials['d3TenantId'])
            ->setId($this->userResponse->getId());

        return $interAppuser;
    }

    private function getD3User(): User
    {
        $user = new User();

        $user
            ->setId($this->userResponse->getId())
            ->setGroups($this->userResponse->getGroups())
            ->setRoles(
                $this->permissionManager->getTenantPermissionsArray(
                    $this->credentials['d3TenantId'],
                    $this->userResponse->getGroups()
                )
            )
            ->setFirstName($this->userResponse->getName()->getGivenName())
            ->setLastName($this->userResponse->getName()->getFamilyName())
            ->setEmails($this->userResponse->getEmails())
            ->setUsername($this->userResponse->getUserName())
            ->setDisplayName($this->userResponse->getDisplayName())
            ->setBearerToken($this->bearer)
            ->setBaseUri($this->credentials['d3BaseUri'])
            ->setTenantId($this->credentials['d3TenantId'])
            ->setPhotos($this->userResponse->getPhotos());

        return $user;
    }
}
