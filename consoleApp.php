<?php

require_once 'vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

//Команда
class StringFormatterCommand extends Command
{
    protected static $defaultName = 'strformat';

    public static function output()
    {
        return 'im Alive';
    }

    protected function configure(): void
    {   //Description and help
        $this->setDescription('Formates your string');

        //Required input parameter
        $this->addArgument
        (
            'string_to_format',
            InputArgument::IS_ARRAY,
            'The string to format'
        );

        //Not required input option for another formatting
        $this->addOption
        (
            'another_format',
            'a',
            InputOption::VALUE_NONE,
            'Just an option to change a formatting',
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Введите строку:');
        try {
            $stringToFormat = $input->getArgument('string_to_format');
            if (empty($stringToFormat)) {
                throw new InvalidArgumentException();
            }
            $stringToFormat = implode($stringToFormat);
            $option = $input->getOption('another_format');
            $output->writeln('Получена новая строка');
            $output->writeln($this->stringFormatter($stringToFormat, $option));
            return self::SUCCESS;
        } catch (InvalidArgumentException $e) {
            $output->writeln('Вы ввели пустую строку, попробуйте еще раз',);
            return self::FAILURE;
        }
    }

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
$application->add(new StringFormatterCommand());
$application->run();