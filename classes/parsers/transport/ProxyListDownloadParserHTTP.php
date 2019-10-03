<?php

namespace classes\parsers\transport;

use classes\parsers\BaseParser;
use classes\db\ProxyListEntity;

class ProxyListDownloadParserHTTP extends BaseParser {

	protected $isSecure = 'HTTP';

	public function parse() {
		$result = $this->prepareDownload()->download();

		if (!$result) {
			return [];
		}

		$result = json_decode($result, true);
		$data = $result[0]['LISTA'];

		$entity = new ProxyListEntity();

		foreach ($data as $row) {
			$entity->insert(
				$entity->prepare($row['IP'], $row['PORT'])
					->add('type_enum', $this->isSecure)
					->add('hide_enum', $row['ANON'])
					->add('country_enum', $row['COUNTRY'])
			);
		}

		$this->missing = $entity->getMissing();

		return $entity->getData();
	}

	public function getURL(): string {
		return "https://www.proxy-list.download/api/v0/get?l=en&t=http";
	}
}