<?php

declare(strict_types=1);

namespace OCA\Epubviewer\Listener;

use OCA\Epubviewer\AppInfo\Application;
use OCA\Files\Event\LoadAdditionalScriptsEvent;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use OCP\Util;

/**
 * @template-implements IEventListener<Event>
 */
class FilesLoadAdditionalScriptsListener implements IEventListener {

	public function __construct() {
	}

	public function handle(Event $event): void {
		if (!($event instanceof LoadAdditionalScriptsEvent)) {
			return;
		}
		Util::addInitScript(Application::APP_ID, 'epubviewer-main');

		// We currently don't have a custom stylesheet, but you can uncomment this line the day we need it
		// Util::addStyle(Application::APP_ID, 'epubviewer-main');
	}
}
