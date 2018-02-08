<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 08.02.18
 * Time: 11:39
 */

namespace AppBundle\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TaxCalculatorCommand.
 */
class TaxCalculatorCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('tax:calculator')
            ->setDescription('Calculate taxes')
            ->addArgument('source')
            ->addArgument('from')
            ->addArgument('to');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $from = new \DateTime($input->getArgument('from'));
        $to = new \DateTime($input->getArgument('to'));

        $result = $this->getContainer()->get('tax_calculator')->calculate($input->getArgument('source'), $from, $to);

        $output->writeln(
            'Доход за отчетный период: ' . number_format($result, 2, '.', ' ')
        );
        $output->writeln(
            'ЕН за отчетный период: ' . number_format($result * 0.05, 2, '.', ' ')
        );
    }
}
