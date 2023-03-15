<?php

namespace Liondeer\Framework\Command;

use Doctrine\Common\Annotations\Annotation;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;


class MakeDvelopFeatureControllerCommand extends AbstractMaker
{
    //####################################
    //TODO Noch nicht funktionsfähig
    //TODO makerBundle in Dependency
    //####################################

    public static function getCommandName(): string
    {
        return 'make:dvelop-feature-controller';
    }

    public static function getCommandDescription(): string
    {
        return 'Erstellt einen Feature Controller mit Kachel für d.velop d.3ecm';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConf)
    {
        $command
            ->setDescription('Erstellt einen Feature Controller mit Kachel für d.velop d.3ecm')
            ->addArgument(
                'name',
                InputArgument::OPTIONAL,
                sprintf(
                    'Wähle einen Namen für dein Feature (z.B. <fg=yellow>%s</>)',
                    Str::asClassName(Str::getRandomTerm())
                )
            )
            ->addArgument(
                'subtitle',
                InputArgument::OPTIONAL,
                sprintf('Wähle einen Zusatztitel für dein Feature')
            )
            ->addArgument(
                'description',
                InputArgument::OPTIONAL,
                sprintf('Wähle eine Beschreibung für dein Feature')
            )
            ->addArgument(
                'summary',
                InputArgument::OPTIONAL,
                sprintf('Wähle eine Zusammenfassung für dein Feature')
            )
            ->addArgument(
                'icon',
                InputArgument::OPTIONAL,
                sprintf('Wähle ein Icon für dein Feature, (z.B. <fg=yellow>%s</>)', 'dv-tags')
            )
            ->addArgument(
                'icon-color',
                InputArgument::OPTIONAL,
                sprintf('Wähle eine Icon-Farbe für dein Feature, (z.B. <fg=yellow>%s</>)', 'pumpkin')
            )
            ->addOption(
                'no-template',
                null,
                InputOption::VALUE_NONE,
                'Setze die Option, um das Generieren des Templates zu verhindern.'
            );
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $name = $input->getArgument('name');
        $controllerName = $name . 'FeatureController';

        $subtitle = $input->getArgument('subtitle');
        $description = $input->getArgument('description');
        $summary = $input->getArgument('summary');
        $icon = $input->getArgument('icon');
        $iconColor = $input->getArgument('icon-color');

        $indexUrl = strtolower(str_replace(" ", "/", $name));
        $indexUrlName = strtolower(str_replace(" ", "_", $name) . "_feature");

        $controllerClassNameDetails = $generator->createClassNameDetails(
            $controllerName,
            'Controller\\'
        );

        $noTemplate = $input->getOption('no-template');
        $templateName = $indexUrlName . '/index.html.twig';
        $controllerPath = $generator->generateController(
            $controllerClassNameDetails->getFullName(),
            $generator->getRootDirectory() . '/liondeer/ControllerSkeletons/FeatureController.tpl.php',
            [
                'title' => $name,
                'subtitle' => $subtitle,
                'description' => $description,
                'summary' => $summary,
                'icon' => $icon,
                'icon_color' => $iconColor,
                'index_url_name' => $indexUrlName,
                'index_url' => $indexUrl,
                'with_template' => $this->isTwigInstalled() && !$noTemplate,
                'template_name' => $templateName,
            ]
        );

        if ($this->isTwigInstalled() && !$noTemplate) {
            $generator->generateTemplate(
                $templateName,
                'controller/twig_template.tpl.php',
                [
                    'controller_path' => $controllerPath,
                    'root_directory' => $generator->getRootDirectory(),
                    'class_name' => $controllerClassNameDetails->getShortName(),
                ]
            );
        }

        $generator->writeChanges();

        $this->writeSuccessMessage($io);
        $io->write('Der Feature Controller ' . $controllerName . ' wurde erstellt!');
        $io->newLine(1);
        $io->write(
            'Um ihn zu aktivieren, füge ihn zum Konstruktor in <fg=green>src/ControllerRegistrator.php</> hinzu.'
        );
    }

    private function isTwigInstalled()
    {
        return class_exists(TwigBundle::class);
    }

    public function configureDependencies(DependencyBuilder $dependencies)
    {
        $dependencies->addClassDependency(
            Annotation::class,
            'doctrine/annotations'
        );
    }
}