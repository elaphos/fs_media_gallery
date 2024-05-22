<?php

declare(strict_types=1);

/*
 * Copyright (C) 2024 Christian Racan
 * ----------------------------------------------
 * new version of sf_media_gallery for TYPO3 v12
 * The TYPO3 project - inspiring people to share!
 * ----------------------------------------------
 */

namespace MiniFranske\FsMediaGallery\Pagination;

use TYPO3\CMS\Core\Pagination\AbstractPaginator;

class ExtendedArrayPaginator extends AbstractPaginator
{
    private array $paginatedItems = [];

    private array $itemsBefore = [];

    private array $itemsAfter = [];

    public function __construct(
        private readonly array $items,
        int $currentPageNumber = 1,
        int $itemsPerPage = 10
    ) {
        $this->setCurrentPageNumber($currentPageNumber);
        $this->setItemsPerPage($itemsPerPage);

        $this->updateInternalState();
    }

    /**
     * @return iterable|array
     */
    public function getPaginatedItems(): iterable
    {
        return $this->paginatedItems;
    }

    protected function updatePaginatedItems(int $itemsPerPage, int $offset): void
    {
        $this->itemsBefore = array_slice($this->items, 0, $offset);
        $this->paginatedItems = array_slice($this->items, $offset, $itemsPerPage);
        $this->itemsAfter = array_slice($this->items, $offset + $itemsPerPage);
    }

    protected function getTotalAmountOfItems(): int
    {
        return count($this->items);
    }

    protected function getAmountOfItemsOnCurrentPage(): int
    {
        return count($this->paginatedItems);
    }

    public function getItemsBefore(): iterable
    {
        return $this->itemsBefore;
    }

    public function getItemsAfter(): iterable
    {
        return $this->itemsAfter;
    }
}
