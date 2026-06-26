/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

import Modal from '@typo3/backend/modal.js';
import { SeverityEnum } from '@typo3/backend/enum/severity.js';

/**
 * Module: @minifranske/fs-media-gallery/context-menu-actions
 *
 * JavaScript to handle fs_media_gallery actions from the file list context menu.
 */
class ContextMenuActions {
  static getReturnUrl() {
    return encodeURIComponent(top.list_frame.document.location.pathname + top.list_frame.document.location.search);
  }

  /**
   * Show a message when no media storage folder is configured.
   */
  static missingMediaFolder(table, uid, dataset) {
    Modal.advanced({
      content: dataset.title,
      severity: SeverityEnum.warning,
    });
  }

  /**
   * Open the media album edit (or new) form in FormEngine.
   */
  static mediaAlbum(table, uid, dataset) {
    const albumRecordUid = parseInt(dataset.albumRecordUid || '0', 10);
    const returnUrl = '&returnUrl=' + ContextMenuActions.getReturnUrl();

    if (albumRecordUid > 0) {
      top.TYPO3.Backend.ContentContainer.setUrl(
        top.TYPO3.settings.FormEngine.moduleUrl
        + '&edit[sys_file_collection][' + albumRecordUid + ']=edit'
        + returnUrl
      );
    } else {
      top.TYPO3.Backend.ContentContainer.setUrl(
        top.TYPO3.settings.FormEngine.moduleUrl
        + '&edit[sys_file_collection][' + dataset.pid + ']=new'
        + '&defVals[sys_file_collection][parentalbum]=' + dataset.parentUid
        + '&defVals[sys_file_collection][title]=' + encodeURIComponent(dataset.title)
        + '&defVals[sys_file_collection][storage]=' + dataset.storage
        + '&defVals[sys_file_collection][folder]=' + encodeURIComponent(dataset.folder)
        + '&defVals[sys_file_collection][type]=folder'
        + returnUrl
      );
    }
  }
}

export { ContextMenuActions as default };
