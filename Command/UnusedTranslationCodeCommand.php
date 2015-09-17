<?php

namespace Afe\TranslationToolBundle\Command;


use Afe\TranslationToolBundle\Service\YmlCheckTranslationCode;
use Iota\CommonBundle\Service\Dashboard\EquipmentDashboardAggregationService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UnusedTranslationCodeCommand extends ContainerAwareCommand {

    protected function configure()
    {
        $this
            ->setName('afe:translation:unused:codes')
            ->setDescription('check if all translation code are used');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln((new \DateTime())->format('d/m/Y H:i:s'));
        /** @var ContainerInterface $container */
        $container = $this->getContainer();

        /** @var YmlCheckTranslationCode $ymlCheckTranslationCode */
        $ymlCheckTranslationCode = $container->get('yml_check_translation_code');

        $unusedTranslationsCode = $ymlCheckTranslationCode->runCheckUnusedTranslationsCode();
        $output->writeln("===========================================================================");
        $output->writeln("===========================================================================");
        $output->writeln("===========================================================================");
        $output->writeln("======================== UNUSED TRANSLATIONS KEYS =========================");
        $output->writeln("===========================================================================");
        $output->writeln("====== ".$unusedTranslationsCode->analyzedCodesNumber." translations code analyzed");
        $output->writeln("====== ".$unusedTranslationsCode->unusedCodesNumber." unused translations code found in ".count($unusedTranslationsCode->unusedCodes). " files");
        foreach ($unusedTranslationsCode->unusedCodes as $filePath => $translationCodeElements) {
            $output->writeln("\n************ FILE : ".$filePath." (". count($translationCodeElements)." unused codes)");
            foreach ($translationCodeElements as $translationCodeElement) {
                $output->writeln($translationCodeElement->translationCode);
            }
        }
        $output->writeln((new \DateTime())->format('d/m/Y H:i:s'));
    }

}
