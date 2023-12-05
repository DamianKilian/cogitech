<?php

namespace App\Command;

use App\Service\LoadPostsService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

#[AsCommand(
    name: 'load-posts',
    description: 'Load posts from test API and save them to db',
)]
class LoadPostsCommand extends Command
{
    public function __construct(private LoadPostsService $loadPostsService)
    {
        parent::__construct();
    }

    // protected function configure(): void
    // {
    //     $this
    //         ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
    //         ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
    //     ;
    // }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $result = $this->loadPostsService->loadPosts();

        if ('object' === gettype($result) && $result instanceof Throwable) {
            $io->error($result->getMessage());
        }else{
            $io->success($result);
        }
        return Command::SUCCESS;
    }
}
