<?php

declare(strict_types=1);

namespace MiniFranske\FsMediaGallery\Command;

use MiniFranske\FsMediaGallery\Service\SlugService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Regeneriert die Slugs der Media-Alben (sys_file_collection). Nuetzlich, um nach
 * Aenderungen am Slug-Aufbau (z. B. verschachtelte Eltern-Pfade) den Bestand
 * nachzuziehen. Per TYPO3-Scheduler aufrufbar.
 */
#[AsCommand(
    name: 'fsmediagallery:updateslugs',
    description: 'Regeneriert die Slugs aller Media-Album-Records (inkl. verschachtelter Eltern-Pfade).'
)]
class UpdateAlbumSlugsCommand extends Command
{
    public function __construct(private readonly SlugService $slugService)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('only-empty', null, InputOption::VALUE_NONE, 'Nur leere Slugs fuellen (statt alle neu zu erzeugen)')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Nur anzeigen, was sich aendern wuerde');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $onlyEmpty = (bool)$input->getOption('only-empty');
        $dryRun = (bool)$input->getOption('dry-run');

        $changes = $this->slugService->regenerateSlugs($onlyEmpty, $dryRun);

        if ($changes === []) {
            $io->success('Keine Slugs zu aktualisieren.');

            return Command::SUCCESS;
        }

        foreach ($changes as $change) {
            $io->writeln(sprintf(
                '#%d: %s -> %s',
                $change['uid'],
                $change['old'] === '' ? '(leer)' : $change['old'],
                $change['new']
            ));
        }

        $io->success(sprintf(
            '%s%d Album-Slug(s) %s.',
            $dryRun ? '[DRY-RUN] ' : '',
            count($changes),
            $dryRun ? 'wuerden aktualisiert' : 'aktualisiert'
        ));

        return Command::SUCCESS;
    }
}
