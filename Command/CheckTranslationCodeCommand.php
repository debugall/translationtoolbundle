<?php

namespace Afe\TranslationToolBundle\Command;


use Afe\TranslationToolBundle\Service\YmlCheckTranslationCode;
use Iota\CommonBundle\Service\Dashboard\EquipmentDashboardAggregationService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CheckTranslationCodeCommand extends ContainerAwareCommand {

    protected function configure()
    {
        $this
            ->setName(' ')
            ->setDescription('check if any translations code is duplicated');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var ContainerInterface $container */
        $container = $this->getContainer();

        /** @var YmlCheckTranslationCode $ymlCheckTranslationCode */
        $ymlCheckTranslationCode = $container->get('yml_check_translation_code');

        $duplicatedTranslationDTO = $ymlCheckTranslationCode->runCheckDuplicatedTranslationsCode();
        $output->writeln("=================================================================");
        $output->writeln("================= DUPLICATED TRANSLATIONS KEYS ==================");
        $output->writeln("=================================================================");
        $output->writeln("====== ".$duplicatedTranslationDTO->analyzedCodesNumber." translations code analyzed");
        $output->writeln("====== ".$duplicatedTranslationDTO->duplicatedCodesNumber." duplicated translations code found");
        foreach ($duplicatedTranslationDTO->duplicatedCodes as $duplicatedCode) {
            $output->writeln($duplicatedCode);
        }

    }

}
