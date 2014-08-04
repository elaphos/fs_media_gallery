<?php
namespace MiniFranske\FsMediaGallery\Hooks;

/*                                                                        *
 * This script is part of the TYPO3 project.                              *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * ItemsProcFuncHook
 */
class ItemsProcFuncHook {

	/**
	 * Sets the available actions for settings.switchableControllerActions
	 *
	 * @param array &$config
	 * @return void
	 */
	public function getItemsForSwitchableControllerActions(array &$config) {
		$availableActions = array(
			'nestedList'	=> 'MediaAlbum->nestedList;MediaAlbum->showAsset',
			'flatList'		=> 'MediaAlbum->flatList;MediaAlbum->showAlbum;MediaAlbum->showAsset',
			'showAlbum'		=> 'MediaAlbum->showAlbumByConfig;MediaAlbum->showAsset',
			'randomAsset'	=> 'MediaAlbum->randomAsset',
		);
		$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['fs_media_gallery']);
		$allowedActions = array();
		$allowedActionsFromExtConf = array();
		if (!empty($extConf['allowedActionsInFlexforms'])) {
			$allowedActionsFromExtConf = GeneralUtility::trimExplode(',', $extConf['allowedActionsInFlexforms']);
		}
		foreach ($allowedActionsFromExtConf as $allowedActionFromExtConf) {
			if (!empty($availableActions[$allowedActionFromExtConf])) {
				$allowedActions[$allowedActionFromExtConf] = $availableActions[$allowedActionFromExtConf];
			}
		}
		// check items
		foreach ($config['items'] as $key => $item) {
			if (!in_array($item[1], $allowedActions)) {
				unset($config['items'][$key]);
			}
		}
	}

}