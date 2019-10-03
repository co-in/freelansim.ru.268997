<?php

namespace classes\parsers;

use classes\output\IOutput;

abstract class BaseParser implements IParser {

	protected $cureHandler;

	protected $output;

	protected $missing;

	public function __construct(IOutput $output) {
		$this->output = $output;
	}

	protected function prepareDownload(): self {
		$this->cureHandler = curl_init($this->getURL());
		curl_setopt($this->cureHandler, CURLOPT_RETURNTRANSFER, true);

		return $this;
	}

	protected function download(): string {
		return curl_exec($this->cureHandler);
	}

	public function getMissing(): array {
		return $this->missing;
	}
}