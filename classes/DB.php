<?php

class DB extends SQLite3 {

	public function __construct() {
		$this->open(__DIR__ . '/../db/lojinha.sqlite');
	}

}