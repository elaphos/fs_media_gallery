<?php

declare(strict_types=1);

namespace MiniFranske\FsMediaGallery\Slug;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Slug-postModifier fuer verschachtelte Alben: stellt dem Album-Slug den Pfad
 * ALLER Eltern-Alben voran (z. B. opa/eltern/kind).
 *
 * Registriert in der TCA via generatorOptions.postModifiers fuer
 * sys_file_collection.slug.
 */
class SlugModifier
{
    /**
     * @var array<string, mixed>
     */
    protected array $configuration = [];

    /**
     * @param array<string, mixed> $configuration
     */
    public function addParentSlug(array $configuration, SlugHelper $slugHelper): string
    {
        $this->configuration = $configuration;

        $record = (array)($configuration['record'] ?? []);
        $ownSlug = $this->toString($configuration['slug'] ?? '');

        // parentalbum primaer aus dem (zu speichernden) Record; Fallback: aus der DB
        // anhand der uid (z. B. wenn das Feld nicht im Record-Array mitgegeben wird).
        $parentUid = $this->toInt($record['parentalbum'] ?? 0);
        if ($parentUid === 0) {
            $selfUid = $this->toInt($record['uid'] ?? 0);
            if ($selfUid > 0) {
                $self = $this->fetchAlbum($selfUid);
                $parentUid = $self['parentalbum'] ?? 0;
            }
        }

        $prefix = $this->buildParentPrefix($parentUid, $slugHelper, $this->fieldSeparator());

        if ($prefix === '') {
            return $ownSlug;
        }

        return $ownSlug === '' ? $prefix : $prefix . $this->fieldSeparator() . $ownSlug;
    }

    /**
     * Baut rekursiv den Slug-Pfad der Eltern-Kette (oberstes -> direktes Elternalbum)
     * aus deren Titeln auf. $seen verhindert Endlosschleifen bei zirkulaeren Bezuegen.
     *
     * @param array<int, true> $seen
     */
    protected function buildParentPrefix(int $albumUid, SlugHelper $slugHelper, string $separator, array $seen = []): string
    {
        if ($albumUid <= 0 || isset($seen[$albumUid])) {
            return '';
        }
        $seen[$albumUid] = true;

        $album = $this->fetchAlbum($albumUid);
        if ($album === null) {
            return '';
        }

        $ownSegment = $slugHelper->sanitize($this->toString($album['title']));
        $parentPrefix = $this->buildParentPrefix($album['parentalbum'], $slugHelper, $separator, $seen);

        if ($ownSegment === '') {
            return $parentPrefix;
        }

        return $parentPrefix === '' ? $ownSegment : $parentPrefix . $separator . $ownSegment;
    }

    /**
     * @return array{title: string, parentalbum: int}|null
     */
    protected function fetchAlbum(int $uid): ?array
    {
        $tableName = $this->toString($this->configuration['tableName'] ?? 'sys_file_collection');
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable($tableName);
        // Eltern-Album unabhaengig von hidden/starttime etc. finden (Pfad-Aufbau).
        $queryBuilder->getRestrictions()->removeAll();
        $row = $queryBuilder
            ->select('title', 'parentalbum')
            ->from($tableName)
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, Connection::PARAM_INT))
            )
            ->executeQuery()
            ->fetchAssociative();

        if (!is_array($row)) {
            return null;
        }

        return [
            'title' => $this->toString($row['title'] ?? ''),
            'parentalbum' => $this->toInt($row['parentalbum'] ?? 0),
        ];
    }

    private function fieldSeparator(): string
    {
        $config = (array)($this->configuration['configuration'] ?? []);
        $generatorOptions = (array)($config['generatorOptions'] ?? []);

        return $this->toString($generatorOptions['fieldSeparator'] ?? '/');
    }

    private function toString(mixed $value): string
    {
        return is_scalar($value) ? (string)$value : '';
    }

    private function toInt(mixed $value): int
    {
        return is_numeric($value) ? (int)$value : 0;
    }
}
