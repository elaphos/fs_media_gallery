<?php

declare(strict_types=1);

/*
 * (c) 2024 rc design visual concepts (rc-design.at)
 * _________________________________________________
 * The TYPO3 project - inspiring people to share!
 * _________________________________________________
 */

namespace MiniFranske\FsMediaGallery\Hooks;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Frans Saris <franssaris@gmail.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use MiniFranske\FsMediaGallery\Event\DocHeaderButtonsEventListener;
use MiniFranske\FsMediaGallery\Service\AbstractBeAlbumButtons;
use Psr\EventDispatcher\EventDispatcherInterface;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Hook to add extra button to DocHeaderButtons in file list.
 */
class DocHeaderButtonsHook extends AbstractBeAlbumButtons
{
    protected function createLink(string $title, string $shortTitle, Icon $icon, string $url, bool $addReturnUrl = true): array
    {
        return [
            'title' => $title,
            'icon' => $icon,
            'url' => $url . ($addReturnUrl ? '&returnUrl=' . rawurlencode((string)$_SERVER['REQUEST_URI']) : ''),
        ];
    }

    /**
     * Add media album buttons to file list.
     */
    public function moduleTemplateDocHeaderGetButtons(array $params, ButtonBar $buttonBar): array
    {
        $buttons = $params['buttons'];

        // Erstellen Sie eine Instanz des Event-Objekts
        $event = new DocHeaderButtonsEventListener($params, $buttonBar);

        // Feuern Sie das Event und lassen Sie die Listener die Arbeit erledigen
        GeneralUtility::makeInstance(EventDispatcherInterface::class)->dispatch($event);

        // Überprüfen Sie, ob die Propagation gestoppt wurde
        if ($event->isStopped()) {
            // Falls gestoppt, kehren Sie zurück
            return $buttons;
        }

        if (
            $buttons->getParsedBody()['M'] ?? $buttons->getQueryParams()['M'] ?? null === 'file_FilelistList'
            || $buttons->getParsedBody()['route'] ?? $buttons->getQueryParams()['route'] ?? null === '/file/FilelistList/'
            || $buttons->getParsedBody()['route'] ?? $buttons->getQueryParams()['route'] ?? null === '/module/file/FilelistList'
        ) {
            foreach ($this->generateButtons((string)$buttons->getParsedBody()['id'] ?? $buttons->getQueryParams()['id'] ?? null) as $buttonInfo) {
                $button = $buttonBar->makeLinkButton();
                $button->setShowLabelText(true);
                $button->setIcon($buttonInfo['icon']);
                $button->setTitle($buttonInfo['title']);
                if (str_starts_with((string)$buttonInfo['url'], 'alert')) {
                    // using CSS class to trigger confirmation in modal box
                    $button->setClasses('t3js-modal-trigger')
                        ->setDataAttributes([
                            'severity' => 'warning',
                            'title' => $buttonInfo['title'],
                            'bs-content' => htmlspecialchars(substr((string)$buttonInfo['url'], 6)),
                        ]);
                } else {
                    $button->setHref($buttonInfo['url']);
                }
                $buttons['left'][2][] = $button;
            }
        }

        return $buttons;
    }
}
