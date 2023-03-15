<?php


namespace Liondeer\Framework\Model;


use JetBrains\PhpStorm\ArrayShape;
use Liondeer\Controller\AbstractFeatureController;
use Liondeer\Exception\LiondeerD3FrameworkException;
use ReflectionClass;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractConfigFeatureHeadlineModel implements AbstractConfigFeatureHeadlineInterface
{
    private string $name;
    private string $caption;
    private string $description;

    /** @var ConfigFeatureModel[] */
    private array $menuItems;
    private array $categories;

    public function __construct(
        private TranslatorInterface $translator,
        private Security $security
    ) {
        $reflection = new ReflectionClass($this);
        $this->name = $reflection->getName();
    }

    /**
     * @throws \Liondeer\Exception\LiondeerD3FrameworkException
     */
    #[ArrayShape(["caption" => "string", "description" => "string", "menuItems" => "array"])]
    public function getConfig(): array
    {
        $headlineConfig = [
            "caption" => $this->translator->trans($this->caption),
            "description" => $this->translator->trans($this->description),
            "menuItems" => [],
            "categories" => []
        ];

        $orderedMenuItems = [];
        foreach ($this->menuItems as $configFeatureModel) {
            /** @var AbstractFeatureController $featureController */
            if (!is_a($configFeatureModel, ConfigFeatureModel::class)) {
                $reflection = new ReflectionClass($configFeatureModel);
                $message = FeatureModel::class . ' excepted, got ' . $reflection->getName();
                throw new LiondeerD3FrameworkException($message, 'LD-1002');
            }
            $orderedMenuItems[$configFeatureModel->getOrder()] = $configFeatureModel;
        }
        ksort($orderedMenuItems);

        foreach ($orderedMenuItems as $configFeatureModel) {
            $granted = false;
            foreach ($configFeatureModel->getAuthorizedRoles() as $authorizedRole) {
                if (
                    $this->security->isGranted($authorizedRole)
                ) {
                    $granted = true;
                }
            }
            if (!$granted || !$configFeatureModel->isVisible()) {

                continue;
            }

            array_push($headlineConfig['menuItems'], $configFeatureModel->getConfig());
        }

        foreach ($this->categories as $key => $category) {
            $categoryArray['id'] = $key;
            $categoryArray['caption'] = $this->translator->trans($category);
            array_push($headlineConfig['categories'], $categoryArray);
        }

        return $headlineConfig;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setCaption(string $caption): AbstractConfigFeatureHeadlineModel
    {
        $this->caption = $caption;

        return $this;
    }

    public function setDescription(string $description): AbstractConfigFeatureHeadlineModel
    {
        $this->description = $description;

        return $this;
    }

    public function addMenuItem(ConfigFeatureModel $configFeatureModel): AbstractConfigFeatureHeadlineModel
    {
        $this->menuItems[$configFeatureModel->getName()] = $configFeatureModel;

        return $this;
    }


    public function removeMenuItem(ConfigFeatureModel $configFeatureModel): AbstractConfigFeatureHeadlineModel
    {
        unset($this->menuItems[$configFeatureModel->getName()]);

        return $this;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): AbstractConfigFeatureHeadlineModel
    {
        $this->categories = $categories;

        return $this;
    }


}