<?php

namespace App\Command;

use App\Repository\GameRepository;
use App\Service\TextService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SlugCommand extends Command
{
    private TextService $textService;
    private GameRepository $gameRepository;
    private EntityManagerInterface $em;


    public function __construct(TextService $textService, GameRepository $gameRepository, EntityManagerInterface $em)
    {
        parent::__construct();
        $this->textService = $textService;
        $this->gameRepository = $gameRepository;
        $this->em = $em;

    }

    public function configure()
    {
        $this->setName('app:generate-slug')
            ->setDescription('Update game slug based on their name')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $games = $this->gameRepository->findAll();
        $output->writeln('Command starting...');
        $progressBar = new ProgressBar($output, count($games));
        $progressBar->start();

        // Traitement pour générer les slugs puis les modifier en BDD
        foreach ($games as $game){
            // edit the slug attribute, using its name and a method of text service
            $game->setSlug($this->textService->slugify($game->getName()));
            // update slug in the database
            $this->em->persist($game);
            // A chaque fin de traitement, on avance la progressbar
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->em->flush();
        $output->writeln('Command finished!');
        return 0;
    }
}