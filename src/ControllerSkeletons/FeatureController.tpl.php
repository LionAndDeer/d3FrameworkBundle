<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

use Liondeer\Controller\AbstractFeatureController;
use Liondeer\Model\FeatureModel;

class <?= $class_name; ?> extends AbstractFeatureController
{
    public function __construct(TranslatorInterface $translator)
    {
        parent::__construct($translator);
    }

    public function defineFeature()
    {
        /** @var FeatureModel $model */
        $this->featureModel = $this->generateFeatureModel()
        ->setUrl($this->generateUrl('<?= $index_url_name ?>'))
        ->setTitle('<?= $title ?>')
        ->setIconUri('<?= $icon ?>')
        ->setDescription('<?= $description ?>')
        ->setSubtitle('<?= $subtitle ?>')
        ->setSummary('<?= $summary ?>')
        ->setColor('<?= $icon_color ?>')
        ->setBadgeCount(1)
        ;
    }

    #[Route('/<?= $index_url ?>', name: '<?= $index_url_name ?>')
    public function index() <?php if ($with_template) { ?> :Response <?php } else { ?> :JsonResponse <?php } ?>
    {
<?php if ($with_template) { ?>
        return $this->render('<?= $template_name ?>', [
            'controller_name' => '<?= $class_name ?>',
        ]);
<?php } else { ?>
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => '<?= $relative_path; ?>',
        ]);
<?php } ?>
    }
}
