<?php

namespace Liondeer\Framework\Controller;

use App\ControllerRegistrator;
use JetBrains\PhpStorm\Pure;
use Liondeer\Framework\Exception\LiondeerD3FrameworkException;
use Liondeer\Framework\Model\AbstractConfigFeatureHeadlineModel;
use Liondeer\Framework\Model\DmsExtensionModel;
use Liondeer\Framework\Model\FeatureModel;
use ReflectionClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class IndexController extends AbstractController
{
    /** @var AbstractFeatureController[] */
    private array $featureControllers;
    /** @var AbstractConfigFeatureController[] */
    private array $configFeatureControllers;
    /** @var AbstractDmsObjectExtensionController[] */
    private array $dmsObjectExtensionControllers;

    #[Pure]
    public function __construct(
        ControllerRegistrator $controllerRegistrator,
        private TranslatorInterface $translator
    ) {
        $this->featureControllers = $controllerRegistrator->getFeatureControllers();
        $this->configFeatureControllers = $controllerRegistrator->getConfigFeatureControllers();
        $this->dmsObjectExtensionControllers = $controllerRegistrator->getDmsObjectExtensionControllers();
    }

    #[Route(
        '{trailingSlash}',
        name: 'index',
        requirements: ['trailingSlash' => '[/]{0,1}'],
        defaults: ['trailingSlash' => '/'],
        methods: ['GET']
    )]
    public function index(): JsonResponse
    {
        $response = new JsonResponse(
            [
                "_links" => [
                    "configfeatures" => [
                        "href" => $this->generateUrl("configfeatures"),
                    ],
                    "featuresdescription" => [
                        "href" => $this->generateUrl("features"),
                    ],
                    "dmsObjectExtensions" => [
                        "href" => $this->generateUrl("dmsObjectExtensions"),
                    ]
                ]
            ]
        );

        $response->setEncodingOptions(JSON_UNESCAPED_SLASHES);

        return $response;
    }

    /**
     * @
     * @throws LiondeerD3FrameworkException
     */
    #[Route('/features', name: 'features', methods: ['GET'])]
    public function features(): JsonResponse
    {
        $features = [];

        foreach ($this->featureControllers as $featureController) {
            /** @var AbstractFeatureController $featureController */
            $featureModel = $featureController->getFeatureModel();

            $granted = false;
            foreach ($featureModel->getAuthorizedRoles() as $authorizedRole) {
                if (
                    $this->isGranted($authorizedRole)
                    || 'ANONYMOUS' == $authorizedRole
                ) {
                    $granted = true;
                }
            }
            if (!$granted) {
                continue;
            }

            if (!is_a($featureModel, FeatureModel::class)) {
                $reflection = new ReflectionClass($featureModel);
                $message = FeatureModel::class . ' excepted, got ' . $reflection->getName();
                throw new LiondeerD3FrameworkException($message, 1001);
            }
            array_push($features, $featureModel->getConfig());
        }

        $response = new JsonResponse(
            [
                "features" => $features
            ]
        );
        $response->setEncodingOptions(JSON_UNESCAPED_SLASHES);

        return $response;
    }

    /**
     * @throws LiondeerD3FrameworkException
     */
    #[Route('/configfeatures', name: 'configfeatures', methods: ['GET'])]
    public function configfeatures(): JsonResponse
    {
        $configFeatures = [
            "appName" => $this->translator->trans($this->getParameter('d3_app_name')),
            "customHeadlines" => []
        ];

        /** @var AbstractConfigFeatureHeadlineModel[] $configFeatureHeadlineModels */
        $configFeatureHeadlineModels = [];

        /** @var AbstractConfigFeatureController $configFeatureController */
        foreach ($this->configFeatureControllers as $configFeatureController) {
            $configFeatureHeadlineModel = $configFeatureController
                ->getConfigFeatureModel()
                ->getConfigFeatureHeadlineModel();
            $configFeatureHeadlineModel->defineConfigFeatureHeadline();
            $configFeatureHeadlineModels[$configFeatureHeadlineModel->getName()] = $configFeatureHeadlineModel;
        }

        foreach ($configFeatureHeadlineModels as $configFeatureHeadlineModel) {
            $configFeaturesArray = $configFeatureHeadlineModel->getConfig();

            if (count($configFeaturesArray['menuItems']) > 0) {
                array_push($configFeatures['customHeadlines'], $configFeaturesArray);
            }
        }

        $response = new JsonResponse($configFeatures);

        $response->setEncodingOptions(JSON_UNESCAPED_SLASHES);

        return $response;
    }

    /**
     * @throws LiondeerD3FrameworkException
     */
    #[Route("/dmsObjectExtensions", name: "dmsObjectExtensions", methods: ['GET'])]
    public function dmsObjectExtension(Request $request): JsonResponse
    {
        $extensions = [];

        foreach ($this->dmsObjectExtensionControllers as $dmsObjectExtensionController) {
            /** @var AbstractDmsObjectExtensionController $dmsObjectExtensionController */
            $dmsExtensionModel = $dmsObjectExtensionController->getExtensionModel();

            if (!is_a($dmsExtensionModel, DmsExtensionModel::class)) {
                $reflection = new ReflectionClass($dmsExtensionModel);
                $message = DmsExtensionModel::class . ' excepted, got ' . $reflection->getName();
                throw new LiondeerD3FrameworkException($message, 1006);
            }
            array_push($extensions, $dmsExtensionModel->getConfig());
        }

        $response = new JsonResponse(
            [
                "extensions" => $extensions
            ]
        );

        $response->setEncodingOptions(JSON_UNESCAPED_SLASHES);

        return $response;
    }
}
