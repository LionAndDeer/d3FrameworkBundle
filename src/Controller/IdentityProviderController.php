<?php

namespace Liondeer\Framework\Controller;

use Exception;
use Liondeer\Framework\IdentityProvider\InterAppProxy;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IdentityProviderController extends AbstractController
{
    /**
     * @param string $requestId
     * @param string $tenantId
     * @param Request $request
     * @param IdentityProviderInterAppService $identityProvider
     * @return Response
     * @throws InvalidArgumentException
     */
    #[Route('/interappauthenticationcallback/{tenantId}/{requestId}', name: 'interAppAuthenticationCallback', methods: ['POST'])]
    public function interAppAuthenticationCallback(
        string $requestId,
        string $tenantId,
        Request $request,
        InterAppProxy $identityProvider
    ): Response {
        try {
            $identityProvider->interAppAuthenticationCallback($requestId, $tenantId, $request->getContent());
            return new Response("");
        } catch (Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

//    /**
//     * @param string $requestId
//     * @param Request $request
//     * @param IdentityProviderUserService $identityProvider
//     * @return Response
//     */
//    #[Route('/userauthenticationcallback/{tenantId}/{requestId}', name: 'userAuthenticationCallback', methods: ['POST'])]
//    public function userAuthenticationCallback(
//        string $requestId,
//        Request $request,
//        IdentityProviderUserService $identityProvider
//    ): Response {
//        try {
//            $identityProvider->userAuthenticationCallback($requestId, $request->getContent());
//            return new Response("");
//        } catch (Exception $e) {
//            return new Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
//        }
//    }
}
