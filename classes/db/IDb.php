<?php

namespace classes\db;

interface IDb {

	public function findBest(int $type): ?array;

	public function batchInsert(array $data);

	public function increaseScore(string $ip, int $port, int $typeEnum);

	public function updatePing(string $ip, int $port, int $typeEnum, int $ping);
}