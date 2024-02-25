<?php
/**
 * @author Frank de Lange
 * @copyright 2017 Frank de Lange
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later.
 * See the COPYING-README file.
 */

namespace OCA\Epubviewer\Controller;

use OCP\IRequest;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;


use OCA\Epubviewer\Service\BookmarkService;

class BookmarkController extends Controller {

    private $bookmarkService;

	/**
	 * @param string $appName
	 * @param IRequest $request
     * @param BookmarkService $bookmarkService
	 */
    public function __construct($appName,
                                IRequest $request,
                                BookmarkService $bookmarkService ) {

        parent::__construct($appName, $request);
        $this->bookmarkService = $bookmarkService;
    }

	/**
     * @brief return bookmark
     *
     * @NoAdminRequired
     * @NoCSRFRequired
     *
     * @param int $fileId
     * @param string $name
     *
	 * @return array|\OCP\AppFramework\Http\JSONResponse
	 */
    public function get($fileId, $name, $type=null) {
        return $this->bookmarkService->get($fileId, $name, $type);
    }

	/**
     * @brief write bookmark
     *
     * @NoAdminRequired
     * @NoCSRFRequired
     *
     * @param int $fileId
     * @param string $name
     * @param string $value
     *
	 * @return array|\OCP\AppFramework\Http\JSONResponse
	 */
    public function set($fileId, $name, $value, $type=null, $content=null) {
        return $this->bookmarkService->set($fileId, $name, $value, $type, $content);
	}


	/**
     * @brief return cursor for $fileId
     *
     * @NoAdminRequired
     * @NoCSRFRequired
     *
     * @param int $fileId
     *
	 * @return array|\OCP\AppFramework\Http\JSONResponse
	 */
    public function getCursor($fileId) {
        return $this->bookmarkService->getCursor($fileId);
    }

	/**
     * @brief write cursor for $fileId
     *
     * @NoAdminRequired
     * @NoCSRFRequired
     *
     * @param int $fileId
     * @param string $value
     *
	 * @return array|\OCP\AppFramework\Http\JSONResponse
	 */
    public function setCursor($fileId, $value) {
        return $this->bookmarkService->setCursor($fileId, $value);
    }

    /**
     * @brief delete bookmark
     *
     * @NoAdminRequired
     * @NoCSRFRequired
     *
     * @param int $fileId
     * @param string name
     *
     */
    public function delete($fileId, $name) {
        $this->bookmarkService->delete($fileId, $name);
    }

    /**
     * @brief delete cursor
     *
     * @NoAdminRequired
     * @NoCSRFRequired
     *
     * @param int $fileId
     *
     */
    public function deleteCursor($fileId) {
        $this->bookmarkService->deleteCursor($fileId);
    }
}
