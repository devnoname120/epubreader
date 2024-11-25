<?php

namespace OCA\Epubviewer\Controller;

use OCA\Epubviewer\Service\BookmarkService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;
use OCP\AppFramework\Http\JSONResponse;


use OCP\IRequest;

class BookmarkController extends Controller {

	private $bookmarkService;

	/**
	 * @param string $appName
	 * @param IRequest $request
	 * @param BookmarkService $bookmarkService
	 */
	public function __construct($appName,
		IRequest $request,
		BookmarkService $bookmarkService) {

		parent::__construct($appName, $request);
		$this->bookmarkService = $bookmarkService;
	}

	/**
	 * @brief return bookmark
	 *
	 * @param int $fileId
	 * @param string $name
	 *
	 * @return array|JSONResponse
	 */
	#[NoAdminRequired]
	#[NoCSRFRequired]
	public function get($fileId, $name, $type = null) {
		return $this->bookmarkService->get($fileId, $name, $type);
	}

	/**
	 * @brief write bookmark
	 *
	 * @param int $fileId
	 * @param string $name
	 * @param string $value
	 *
	 * @return array|JSONResponse
	 */
	#[NoAdminRequired]
	#[NoCSRFRequired]
	public function set($fileId, $name, $value, $type = null, $content = null) {
		return $this->bookmarkService->set($fileId, $name, $value, $type, $content);
	}


	/**
	 * @brief return cursor for $fileId
	 *
	 * @param int $fileId
	 *
	 * @return array|JSONResponse
	 */
	#[NoAdminRequired]
	#[NoCSRFRequired]
	public function getCursor($fileId) {
		return $this->bookmarkService->getCursor($fileId);
	}

	/**
	 * @brief write cursor for $fileId
	 *
	 * @param int $fileId
	 * @param string $value
	 *
	 * @return array|JSONResponse
	 */
	#[NoAdminRequired]
	#[NoCSRFRequired]
	public function setCursor($fileId, $value) {
		return $this->bookmarkService->setCursor($fileId, $value);
	}

	/**
	 * @brief delete bookmark
	 *
	 * @param int $fileId
	 * @param string name
	 */
	#[NoAdminRequired]
	#[NoCSRFRequired]
	public function delete($fileId, $name): void {
		$this->bookmarkService->delete($fileId, $name);
	}

	/**
	 * @brief delete cursor
	 *
	 * @param int $fileId
	 */
	#[NoAdminRequired]
	#[NoCSRFRequired]
	public function deleteCursor($fileId): void {
		$this->bookmarkService->deleteCursor($fileId);
	}
}
