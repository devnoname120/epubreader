<?php

declare(strict_types=1);

namespace OCA\Epubviewer\Listener;

use OCA\Epubviewer\AppInfo\Application;
use OCP\AppFramework\Http\Events\BeforeTemplateRenderedEvent;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Services\IInitialState;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use OCP\IConfig;
use OCP\IUserSession;

/** @template-implements IEventListener<BeforeTemplateRenderedEvent> */
class BeforeTemplateRenderedListener implements IEventListener {
	private IInitialState $initialState;
	private IUserSession $userSession;
	private IConfig $config;

	public function __construct(
		IInitialState $initialState,
		IUserSession $userSession,
		IConfig $config,
	) {
		$this->initialState = $initialState;
		$this->userSession = $userSession;
		$this->config = $config;
	}

	public function handle(Event $event): void {
		/** @var BeforeTemplateRenderedEvent $event */
		if ($event->getResponse()->getRenderAs() === TemplateResponse::RENDER_AS_USER) {
			$this->initialState->provideLazyInitialState('enableEpub', function () {
				$user = $this->userSession->getUser();
				if ($user !== null) {
					$uid = $user->getUID();
					return $this->config->getUserValue($uid, Application::APP_ID, 'epub_enable', 'true') === 'true';
				}
				return true;
			});

			$this->initialState->provideLazyInitialState('enablePdf', function () {
				$user = $this->userSession->getUser();
				if ($user !== null) {
					$uid = $user->getUID();
					return $this->config->getUserValue($uid, Application::APP_ID, 'pdf_enable', 'false') === 'true';
				}
				return false;
			});

			$this->initialState->provideLazyInitialState('enableCbx', function () {
				$user = $this->userSession->getUser();
				if ($user !== null) {
					$uid = $user->getUID();
					return $this->config->getUserValue($uid, Application::APP_ID, 'cbx_enable', 'true') === 'true';
				}
				return true;
			});
		}
	}
}
