<?php

namespace classes\parsers\transport;

class ProxyListDownloadParserHTTPS extends ProxyListDownloadParserHTTP {

	protected $isSecure = 'HTTPS';

	public function getURL(): string {
		return "https://www.proxy-list.download/api/v0/get?l=en&t=https";
	}
}