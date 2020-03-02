<?php

class Regx 
{
	public $fileName='';
	public $fileContent ="";
	public $oldSiteUrl='';
	public $newSiteURL='';
	public $diffNoOfCharactors=0;
	
	function __construct($fileName)
	{
		$this->fileName = $fileName;
		self::getFileContent();
	}

	public function getFileContent(){
		// echo $this->fileName;
		$filenameandpath = "uploads/".$this->fileName;
		$myfile = fopen($filenameandpath, "r") or die("Unable to open file!");
		$this->fileContent = fread($myfile,filesize($filenameandpath));
		fclose($myfile);
	}

	public function writeToFile($content){
		// echo $this->fileName;
		$filenameandpath = "downloads/".$this->fileName;
		$myfile = fopen($filenameandpath, "w") or die("Unable to open file!");
		fwrite($myfile, $content);
		fclose($myfile);
	}

	public function getOldSiteName(){
		$pattern="~'siteurl', '(.*)',~";

		$success = preg_match($pattern, $this->fileContent, $match);
		if ($success) {			
			return $match[1]; 			
			}
	}

	public function matchAll($oldSiteURL, $newSiteURL)
	{
		// echo '<br>-----------------'.$oldSiteURL;
		// echo '<br>-----------------'.$newSiteURL;

		// $pattern='~s:\d+:\"([^;]*)http://www.ou.ac.lk/ours([^;]*)\";~';
		// $pattern='~s:\d+:\\"([^;]*)'.$oldSiteURL.'([^;]*)\\";~';

		// $pattern ='~s:(\d+):\\\\"([^;]*)'.$oldSiteURL.'([^;]*)\\\\";~';
		$pattern ='~(s:)(\d+)(:\\\\"[^;]*)('.$oldSiteURL.')([^;]*\\\\";)~';

		// echo $pattern;

		// $success = preg_match_all($pattern, $this->fileContent, $match);
		// if ($success) {			
		// 	var_dump($match); 			
		// }else{
		// 	var_dump($match); 
		// }

		$newContent = preg_replace_callback($pattern,function($match){
			// return $match[2]-$this->diffNoOfCharactors.">>>>>>>>>>>>>>>".$this->newSiteURL."|".$match[0] ;
			return $match[1]."".($match[2]-$this->diffNoOfCharactors)."".$match[3].$match[4].$match[5] ;
		},$this->fileContent);

		// $newContent = preg_replace($pattern,"$1"."111222 $3 $newSiteURL $5",$this->fileContent);

		$newContent = str_replace($oldSiteURL,$newSiteURL,$newContent);

		$this->writeToFile($newContent);

		return 'Successfull !';

		// echo $newContent;
	}

	

}


