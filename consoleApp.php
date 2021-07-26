<?php

namespace App;

require_once 'vendor/autoload.php';

use Symfony\Component\Console\Application;

//Класс Команды
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class StringFormatter extends Command
{
    protected static $defaultName = 'command:strformat';

    protected function configure(): void
    {   //Description and help
        $this->setDescription('Formates your string');
        $this->setHelp('Command that formates your string');

        //Required input parameter, string type
        $this->addArgument
        (
            'string_to_format',
            InputArgument::IS_ARRAY,
            'The string to format'
        );

        //Non required input option for another formatting
        $this->addOption
        (
            'another_format',
            'fo',
            InputOption::VALUE_NONE,
            'Just an option to change a formatting',
            1
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Введите строку:');
        $stringToFormat = $input->getArgument('string_to_format');
        $option = $input->getOption('another_format');
        $output->writeln('Получена новая строка');
        $output->writeln($this->stringFormatter($stringToFormat, $option));
    }

    //This is my string
    private function stringFormatter($string, $option)
    {
        $stringArr = str_split($string);
        if (!$option) {
            for ($i = 0; $i < count($stringArr); $i++) {
                $stringArr[$i] =
                    $i % 2
                        ? strtolower($stringArr[$i])
                        : strtoupper($stringArr[$i]);
            }
            $string = implode($stringArr);
            return $string;
        } else {
            for ($i = 0; $i < count($stringArr); $i++) {
                $stringArr[$i] =
                    $i % 2
                        ? strtoupper($stringArr[$i])
                        : strtolower($stringArr[$i]);
            }
            $string = implode($stringArr);
            return $string;
        }
    }
}

$application = new Application();
$application->run();
$application->add(new StringFormatter());
