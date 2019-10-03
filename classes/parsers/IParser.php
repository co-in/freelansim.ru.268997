<?php

namespace classes\parsers;

interface IParser {

	public function getURL(): string;

	public function parse();

	public function getMissing(): array;
}