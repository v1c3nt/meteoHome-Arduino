<?php

namespace App\Command;

use App\Entity\Meteo;
use App\Service\ApiMeteoService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MeteoHistoryCommand extends Command
{
    protected static $defaultName = 'meteoHistory';
    protected static $defaultDescription = 'Add a short description for your command';

    private $em;
    private $apiMeteo;
    
    public function __construct(EntityManagerInterface $em, ApiMeteoService $apiMeteo)
    {
        $this->em = $em;
        $this->apiMeteo = $apiMeteo;

        parent::__construct();
    }


    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $terrasse = $this->apiMeteo->get('192.168.1.160/api')->meteo;

        $terrasseMeteo = (new Meteo())
            ->setPlace('terrasse-sud')
            ->setAt(new DateTime())
            ->setCelsius($terrasse->temperature)
            ->setHumidity($terrasse->humidite)
        ; 
        $this->em->persist($terrasseMeteo);
        $this->em->flush();

        $io->success($terrasseMeteo);

        return Command::SUCCESS;
    }
}
