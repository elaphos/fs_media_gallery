<?php

declare(strict_types=1);

namespace MiniFranske\FsMediaGallery\Command;

use Doctrine\DBAL\Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

#[AsCommand(
    name: 'fs-media-gallery:migratePlugins',
    description: 'Migrate plugin content elements with deprecated list type "fsmediagallery_mediagallery".'
)]
class MigratePluginsCommand extends Command
{
    private OutputInterface $output;
    private SymfonyStyle $io;

    public function __construct(
        private readonly ConnectionPool $connectionPool,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->output = $output;
        $this->io = new SymfonyStyle($input, $output);

        if ($this->updateNecessary()) {
            if ($this->executeUpdate()) {
                return Command::SUCCESS;
            }

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    /**
     * @return bool
     */
    private function executeUpdate(): bool
    {
        $contentElements = $this->getContentElements();
        $count = count($contentElements);

        if ($count > 0) {
            $progressBar = new ProgressBar($this->output, count($contentElements));
            foreach ($contentElements as $contentElement) {
                $flexFormArray = GeneralUtility::xml2array($contentElement['pi_flexform']);
                $pluginName = $this->getFirstControllerActionFromFlexform($flexFormArray);

                if ($pluginName) {
                    $pluginSignature = 'fsmediagallery_' . strtolower($pluginName);
                    unset($flexFormArray['data']['general']['lDEF']['switchableControllerActions']);

                    $flexFormTools = new FlexFormTools();
                    $flexFormString = $flexFormTools->flexArray2Xml($flexFormArray, addPrologue: true);

                    if (!$this->updateContentElement($contentElement['uid'], $pluginSignature, $flexFormString)) {
                        $this->io->error("Plugin uid " . $contentElement['uid'] . " could not be updated");
                        return false;
                    }

                } else {
                    $this->io->error("Plugin name for uid " . $contentElement['uid'] . " could not be determined");
                    return false;
                }
                $progressBar->advance();
            }
            $progressBar->finish();
        }

        return true;
    }

    /**
     * @return bool Whether an update is required (TRUE) or not (FALSE)
     */
    private function updateNecessary(): bool
    {
        try {
            $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
            $count = $queryBuilder
                ->count('uid')
                ->from('tt_content')
                ->where(
                    $queryBuilder->expr()->eq('CType', $queryBuilder->createNamedParameter('list')),
                    $queryBuilder->expr()->eq('list_type', $queryBuilder->createNamedParameter('fsmediagallery_mediagallery'))
                )
                ->executeQuery()
                ->fetchOne();

            if($count > 0) {
                $this->io->info($count . " affected plugins found");
            } else {
                $this->io->info("Nothing to update");
            }

            return $count > 0;
        } catch (Exception) {
        }
        return false;
    }

    /**
     * @return array
     */
    private function getContentElements(): array
    {
        try {
            $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
            return $queryBuilder
                ->select('uid', 'pi_flexform')
                ->from('tt_content')
                ->where(
                    $queryBuilder->expr()->eq('CType', $queryBuilder->createNamedParameter('list')),
                    $queryBuilder->expr()->eq('list_type', $queryBuilder->createNamedParameter('fsmediagallery_mediagallery'))
                )
                ->executeQuery()
                ->fetchAllAssociative();
        } catch (Exception) {
        }
        return [];
    }

    /**
     * @param array $flexFormArray
     * @return string
     */
    private function getFirstControllerActionFromFlexform(array $flexFormArray): string
    {
        $controllerActions = explode(';', $flexFormArray['data']['general']['lDEF']['switchableControllerActions']['vDEF'] ?? '');
        if (is_array($controllerActions)) {
            [, $action] = explode('->', $controllerActions[0]);

            return $action;
        }
        return '';
    }

    /**
     * @param int $uid
     * @param string $listType
     * @param string $piFlexform
     * @return bool
     */
    private function updateContentElement(int $uid, string $listType, string $piFlexform): bool
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
        $count = $queryBuilder
            ->update('tt_content')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, Connection::PARAM_INT))
            )
            ->set('list_type', $listType)
            ->set('pi_flexform', $piFlexform)
            ->executeStatement();

        return $count > 0;
    }
}
