<?php

namespace classes\output;

class ConsoleOutput implements IOutput {

	public function info(string $text): void {
		echo "Info: {$text}\n";
	}

	public function error(string $text): void {
		echo "Error: {$text}\n";

		exit(0);
	}

	public function warning(string $text): void {
		echo "Warning: {$text}\n";
	}
}