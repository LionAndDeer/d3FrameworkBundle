<?php

namespace Liondeer\Framework\Lifecycle;

use App\Lifecycle\PurgeEvent;
use App\Lifecycle\ResubscribeEvent;
use App\Lifecycle\SubscribeEvent;
use App\Lifecycle\UnsubscribeEvent;
use DateTime;
use DateTimeZone;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LifecycleEventController extends AbstractController
{
    public function __construct(
        private SubscribeEvent $subscribeEvent,
        private UnsubscribeEvent $unsubscribeEvent,
        private ResubscribeEvent $resubscribeEvent,
        private PurgeEvent $purgeEvent,
        private LoggerInterface $logger
    ) {
    }

    /**
     * @throws \Exception
     */
    #[Route('/dvelop-cloud-lifecycle-event', name: 'postLifecycleEvent', methods: ['POST'])]
    public function postLifecycleEvent(
        RequestStack $request
    ): JsonResponse {
        $monologContext = [
            "source" => self::class,
            "request" => $request->getCurrentRequest()->toArray(),
            "server_params" => $request->getCurrentRequest()->server->all(),
            "headers" => $request->getCurrentRequest()->headers->all()
        ];
        $lifecycleObject = json_decode($request->getCurrentRequest()->getContent(), true);

        $bodyString = '{"type":"%s","tenantId":"%s","baseUri":"%s"}' . PHP_EOL;
        $parameters = [
            'type' => $lifecycleObject["type"],
            'tenantId' => $lifecycleObject["tenantId"],
            'baseUri' => $lifecycleObject["baseUri"],
        ];
        $bodyString = sprintf($bodyString, $parameters['type'], $parameters['tenantId'], $parameters['baseUri']);

        if ($this->getParameter('app_env') == 'prod') {
            // check if timestamp is not older or newer than 5 minutes from "now"
            $requestTimestamp = new DateTime($request->getCurrentRequest()->headers->get('x-dv-signature-timestamp'));

            $dateTimeZone = new DateTimeZone('UTC');
            $futureTimestamp = new DateTime('now', $dateTimeZone);
            $pastTimestamp = new DateTime('now', $dateTimeZone);
            $futureTimestamp->modify("+5 minutes");
            $pastTimestamp->modify("-5 minutes");

            if (($requestTimestamp < $pastTimestamp) || ($requestTimestamp > $futureTimestamp)) {
                $this->logger->error("Timestamp invalid", $monologContext);

                return new JsonResponse(["returnValue" => "Timestamp invalid"], Response::HTTP_FORBIDDEN);
            }
        }

        $signatureSecret = $this->getParameter("d3_app_secret");
        $decodedSignatureSecret = base64_decode($signatureSecret);

        $requestToHash = $request->getCurrentRequest()->getMethod() . PHP_EOL . $request->getCurrentRequest(
            )->getPathInfo() . PHP_EOL . $request->getCurrentRequest()->getQueryString() . PHP_EOL;
        $headers = explode(",", $request->getCurrentRequest()->headers->get("x-dv-signature-headers"));
        sort($headers);

        foreach ($headers as $header) {
            // header:value
            $requestToHash .= strtolower($header) . ":" . trim(
                    $request->getCurrentRequest()->headers->get($header)
                ) . PHP_EOL;
        }

        // Hash aus body string erzeugen, in hexadezimal umwandeln und an den request string anfügen
        $attachedHexadecimalRequest = hash("sha256", $bodyString);
        $requestToHash .= PHP_EOL . $attachedHexadecimalRequest;

        // Kompletten request string nochmals hashen und in hexadezimal umwandeln
        $hexadecimalRequest = hash("sha256", $requestToHash);

        // Checksumme erzeugen
        $checksum = hash_hmac("sha256", $hexadecimalRequest, $decodedSignatureSecret);
        $bearerToken = str_replace("Bearer ", "", $request->getCurrentRequest()->headers->get("Authorization"));

        if ($checksum == $bearerToken) {
            switch ($lifecycleObject["type"]) {
                case "subscribe":
                    $this->subscribeEvent->processEvent($parameters);
                    break;
                case "resubscribe":
                    $this->resubscribeEvent->processEvent($parameters);
                    break;
                case "unsubscribe":
                    $this->unsubscribeEvent->processEvent($parameters);
                    break;
                case "purge":
                    $this->purgeEvent->processEvent($parameters);
                    break;
                default:
                    $this->logger->error("Invalid event type: " . $lifecycleObject["type"], $monologContext);

                    return new JsonResponse(["returnValue" => "Invalid event type"], Response::HTTP_FORBIDDEN);
            }

            return new JsonResponse(["returnValue" => "OK"], Response::HTTP_OK);
        }

        $this->logger->error("Checksum Error", $monologContext);

        return new JsonResponse(["returnValue" => "Checksum Error"], Response::HTTP_FORBIDDEN);
    }
}