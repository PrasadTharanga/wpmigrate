<?php

class FileHandler{
	static $uploadFolder;
	static $fileType;

	public function __construct($fileType ='sql', $uploadFolder = 'uploads')
	{
		FileHandler::$uploadFolder = $uploadFolder;
		self::$fileType = $fileType;
	}

	public function renderUploadFile()
	{
		
	}
}