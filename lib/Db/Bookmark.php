<?php

namespace OCA\Epubviewer\Db;

use JsonSerializable;

/**
 * @method string getUserId()
 * @method void setUserId(string $userId)
 * @method int getFileId()
 * @method void setFileId(int $fileId)
 * @method string getType()
 * @method void setType(string $type)
 * @method string getName()
 * @method void setName(string $name)
 * @method string getValue()
 * @method void setValue(string $value)
 * @method string|null getContent()
 * @method void setContent(?string $content)
 */
class Bookmark extends ReaderEntity implements JsonSerializable {

	protected $userId;  // user
	protected $fileId;  // book (identified by fileId) for which this mark is valid
	protected $type;    // type, defaults to "bookmark"
	protected $name;    // name, defaults to $location
	protected $value;   // bookmark value (format-specific, eg. page number for PDF, CFI for epub, etc)
	protected $content; // bookmark content (annotations, etc.), can be empty

	public function __construct() {
		parent::__construct();
		$this->addType('userId', 'string');
		$this->addType('fileId', 'integer');
		$this->addType('type', 'string');
		$this->addType('name', 'string');
		$this->addType('value', 'string');
		$this->addType('content', 'string');
	}

	public function jsonSerialize(): array {
		return [
			'userId' => $this->userId,
			'fileId' => $this->fileId,
			'type' => $this->type,
			'name' => $this->name,
			'value' => self::conditional_json_decode($this->value),
			'content' => self::conditional_json_decode($this->content),
			'lastModified' => $this->getLastModified(),
		];
	}

	/**
	 * @psalm-return array{name: string, type: string, value: mixed, content: mixed, lastModified: int}
	 */
	public function toService(): array {
		return [
			'name' => $this->getName(),
			'type' => $this->getType(),
			'value' => self::conditional_json_decode($this->getValue()),
			'content' => self::conditional_json_decode($this->getContent()),
			'lastModified' => $this->getLastModified(),
		];
	}

	public static function conditional_json_decode($el) {
		if (empty($el)) {
			return $el;
		}
		$decoded = json_decode($el, true);
		return (json_last_error() === JSON_ERROR_NONE) ? $decoded : $el;
	}
}
