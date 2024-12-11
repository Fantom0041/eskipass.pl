<?php
class Additional {

	public function DateFormat($date) {
		return substr($date,0,10);
	}

	public function DateFormat2($date) {
		return substr($date,-5);
	}

	public function DateFormatDay($date) {
		return substr($date,-2);
	}

	public function DateMonth($date) {
		return substr($date,5,2);
	}
	public function DateDay($date) {
		return substr($date,8,2);
	}
	
	public function ReformatDate($date,$format) {
		return date($format, strtotime($date));
	}

	public function TimeFormat($time) {
		return substr($time,0,5);
	}

	public function DateMath($date, $add) {
		if($add!="")
			return date('Y-m-d', strtotime($date . $add));
		else
			return "";
	}

	public function DateToTimestamp($date) {
		return strtotime($date);
	}

	public function TimestampToDate($timestamp) {
		return date("Y-m-d", $timestamp);
	}

	public function TimestampToHour($timestamp) {
		$full=date("Y-m-d G:i", $timestamp);
		$tab=explode(" ",$full);
		return $tab[1];
	}
	
	public function WeekDay($ts) {
		$dt=array("Poniedziałek","Wtorek","Środa","Czwartek","Piątek","Sobota","Niedziela");
		$dn=date("N",$ts);
		return $dt[$dn-1];
	}
	
	public function WeekDayShort($ts) {
		$dt=array("Pn","Wt","Śr","Cz","Pt","So","Ni");
		$dn=date("N",$ts);
		return $dt[$dn-1];
	}

	public function MonthName($ts) {
		$m=array("Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień");
		$mn=date("n",$ts);
		return $m[$mn-1];
	}
	
	public function MonthNameD($ts) {
		$m=array("stycznia", "lutego", "marca", "kwietnia", "maja", "czerwca", "lipca", "sierpnia", "września", "października", "listopada", "grudnia");
		$mn=date("n",$ts);
		return $m[$mn-1];
	}
	
	public function createDateRangeArray($strDateFrom,$strDateTo) {
		// takes two dates formatted as YYYY-MM-DD and creates an
		// inclusive array of the dates between the from and to dates.
		$aryRange=array();

		$iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
		$iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

		if ($iDateTo>=$iDateFrom) {
			array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry

			while ($iDateFrom<$iDateTo) {
				$iDateFrom+=86400; // add 24 hours
				array_push($aryRange,date('Y-m-d',$iDateFrom));
			}
		}
		return $aryRange;
	}
	
	public function WeekRange($ts) {
		$year=date("Y", $ts);
		$weeknr=date("W", $ts);
		$offset = date('w', mktime(0,0,0,1,1,$year));
		$offset = ($offset < 5) ? 1-$offset : 8-$offset;
		$monday = mktime(0,0,0,1,1+$offset,$year);
		$date = strtotime('+' . ($weeknr - 1) . ' weeks', $monday);

		$datastart=date("Y-m-d",$date);
		$datakoniec=$this->DateMath($datastart, '+ 6 days');
		return array($datastart, $datakoniec);
	}
	
	public function Odmiana($co,$ile) {
		switch($co) {
			case 'dni':
				if($ile==1) return 'dzień';
				return 'dni';
				break;
		}
	}

	public function Escape( $text ) {
		if ( get_magic_quotes_gpc() ) {
			$text = stripslashes($text);
		}
		if ( !is_numeric($text) ) {
			$text = mysql_real_escape_string($text);
		}
		return $text;
	}

	public function CheckboxToInt ($checked) {
		if($checked=="on") return 1;
		return 0;
	}

	public function Title2Link($text)
	{
		$text = html_entity_decode($text);
		$szukaj    = array(' - ','--',':',';','.',',','"',' ','/','\'','&'  ,'%','(',')','#','!','+','\\','[',']','ďż˝','?','@','=','<','>','&lt;','&gt;',"A","Ą","B","C","Ć","D","E","Ę","F","G","H","I","J","K","L","Ł","M","N","Ń","O","Ó","P","Q","R","S","Ś","T","U","V","W","X","Y","Z","Ż","Ź","a","ą","b","c","ć","d","e","ę","f","g","h","i","j","k","l","ł","m","n","ń","o","ó","p","q","r","s","ś","t","u","v","w","x","y","z","ż","ź");
		$zamieniaj = array('-'  ,'-' ,'' ,'' ,'-' ,'-' ,'' ,'-','-','-' ,'and','procent','-' ,'-' ,'' ,'' ,'' ,'-','-','-','a','','at','-','','','','',"a","a","b","c","c","d","e","e","f","g","h","i","j","k","l","l","m","n","n","o","o","p","q","r","s","s","t","u","v","w","x","y","z","z","z","a","a","b","c","c","d","e","e","f","g","h","i","j","k","l","l","m","n","n","o","o","p","q","r","s","s","t","u","v","w","x","y","z","z","z");
		$szukaj2=array('and8221','and8222','and039','and034','--','*','^','{','}','„','”','“');
		$zamieniaj2=array('','','','','-','','','','','','','');
		$text = trim($text);
		$text = str_replace($szukaj, $zamieniaj, $text);
		$text = str_replace($szukaj2, $zamieniaj2, $text);
		return $text;
	}

	public function Sw2Url($sw)
	{
		return urlencode($sw);
	}
	
	public function Url2Sw($sw)
	{
		return urldecode($sw);
	}
	
	public function makeClickableLinks($s) {
		return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $s);
	}

	public function ToLower($text)
	{
		$szukaj=array('A','Ą','B','C','Ć','D','E','Ę','F','G','H','I','J','K','L','Ł','M','N','Ń','O','Ó','P','Q','R','S','Ś','T','U','V','W','X','Y','Z','Ż','Ź');
		$zamieniaj=array('a','ą','b','c','ć','d','e','ę','f','g','h','i','j','k','l','ł','m','n','ń','o','ó','p','q','r','s','ś','t','u','v','w','x','y','z','ż','ź');
		return str_replace($szukaj, $zamieniaj, $text);
	}

	public function ToUpper($text)
	{
		$szukaj=array('a','ą','b','c','ć','d','e','ę','f','g','h','i','j','k','l','ł','m','n','ń','o','ó','p','q','r','s','ś','t','u','v','w','x','y','z','ż','ź');
		$zamieniaj=array('A','Ą','B','C','Ć','D','E','Ę','F','G','H','I','J','K','L','Ł','M','N','Ń','O','Ó','P','Q','R','S','Ś','T','U','V','W','X','Y','Z','Ż','Ź');
		return str_replace($szukaj, $zamieniaj, $text);
	}

	public function GetLastID($array) {
		$tmp=end($array);
		return $tmp['id'];
	}
	
	public function MakeThumb($image,$newwidth,$thumbname) {
		list($width, $height, $type) = getimagesize($image);
			if($width<$newwidth) $newwidth=$width;
        	$newheight = round($newwidth*$height/$width);

		//czy obrazek zrodlowy nie jest za maly?
		if($height<$newheight) { $newheight_src=$height; $top=round(($newheight-$height)/2); } else { $newheight_src=$newheight; $top=0; }
		if($width<$newwidth) { $newwidth_src=$width; $left=round(($newwidth-$width)/2); $newheight=$height; $top=0; if($newheight<200) { $newheight+=50; $top=25; }  } else {$newwidth_src=$newwidth; $left=0;}


		$thumb = imagecreatetruecolor($newwidth, $newheight); $background = imagecolorallocate($thumb, 255, 255, 255); imagefill($thumb, 0, 0, $background);
		$thumb2 = imagecreatetruecolor($newwidth_src, $newheight_src); imagecolorallocate($thumb2, 255, 255, 255); imagefill($thumb2, 0, 0, $background);

		$fileType = $this->FileExt($thumbname);
		switch($fileType) {
			case('gif'): $source = imagecreatefromgif($image); break;
			case('png'): $source = imagecreatefrompng($image); break;
			default: $source = imagecreatefromjpeg($image);
		}
		//tymczasowa miniaturka przed wpasowaniem w obrazek docelowy
		imagecopyresampled($thumb2, $source, 0, 0, 0, 0, $newwidth_src, $newheight_src, $width, $height);
		//wklejenie tymczasowej do docelowej
		imagecopy($thumb, $thumb2, $left, $top, 0, 0, $newwidth_src, $newheight_src);
		
		$thumb = $this->ImageSharpen($thumb);
		
		switch($fileType) {
			case('gif'): imagegif($thumb, $thumbname); break;
			case('png'): imagepng($thumb, $thumbname,9); break;
			default: imagejpeg($thumb, $thumbname,95);
		}
		return true;
	}

	//crop image to specified width and height
	public function MakeThumb2($image,$newwidth_dest,$newheight_dest,$thumbname) {
		list($width, $height, $type) = getimagesize($image);
        	$newheight = round($newwidth_dest*$height/$width);
		$newwidth = round($width*$newheight_dest/$height);

		//sprawdzamy, czy obrazek jest zbyt wysoki
		if($newheight>$newheight_dest) { $top=round(($newheight-$newheight_dest)/2); $newwidth=$newwidth_dest; } else { $top=0; }

		//czy nie za szeroki
		if($newwidth>$newwidth_dest) { $left=round(($newwidth-$newwidth_dest)/2); $newheight = round($newwidth*$height/$width); } else { $left=0; }

		//obrazek docelowy
		$thumb = imagecreatetruecolor($newwidth_dest, $newheight_dest);
		$background = imagecolorallocate($thumb, 255, 255, 255);
		imagefill($thumb, 0, 0, $background);
		//obrazek temp
		$thumb2 = imagecreatetruecolor($newwidth, $newheight);
		$background = imagecolorallocate($thumb2, 255, 255, 255);
		imagefill($thumb2, 0, 0, $background);

		$fileType = $this->FileExt($thumbname);
		switch($fileType) {
			case('gif'): $source = imagecreatefromgif($image); break;
			case('png'): $source = imagecreatefrompng($image); break;
			default: $source = imagecreatefromjpeg($image);
		}

		//tymczasowa miniaturka przed wycieciem srodka
		imagecopyresampled($thumb2, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		//wycinamy srodek
		imagecopy($thumb, $thumb2, 0, 0, $left, $top, $newwidth_dest, $newheight_dest);
		
		$thumb = $this->ImageSharpen($thumb);
		
		//zapis na dysku
		switch($fileType) {
			case('gif'): imagegif($thumb, $thumbname); break;
			case('png'): imagepng($thumb, $thumbname,9); break;
			default: imagejpeg($thumb, $thumbname,95);
		}
		return true;
	}

	//crop image to specified width and height, but smaller leave as is
	public function MakeThumb3($image,$newwidth_dest,$newheight_dest,$thumbname) {
		list($width, $height, $type) = getimagesize($image);
		//bez rozciagania obrazka gdy za maly
		if($width<$newwidth_dest) $newwidth_dest=$width;
		if($height<$newheight_dest) $newheight_dest=$height;

		//proporcje
        	$newheight = round($newwidth_dest*$height/$width);
		$newwidth = round($width*$newheight_dest/$height);

		//bez rozciagania obrazka gdy za maly
		if($newheight<$newheight_dest) $newheight_dest=$newheight;
		if($newwidth<$newwidth_dest) $newwidth_dest=$newwidth;

		//sprawdzamy, czy obrazek jest zbyt wysoki
		if($newheight>$newheight_dest) { $top=round(($newheight-$newheight_dest)/2); $newwidth=$newwidth_dest; } else { $top=0; }

		//czy nie za szeroki
		if($newwidth>$newwidth_dest) { $left=round(($newwidth-$newwidth_dest)/2); $newheight = round($newwidth*$height/$width); } else { $left=0; }

		//obrazek docelowy
		$thumb = imagecreatetruecolor($newwidth_dest, $newheight_dest);
		$background = imagecolorallocate($thumb, 255, 255, 255);
		imagefill($thumb, 0, 0, $background);
		//obrazek temp
		$thumb2 = imagecreatetruecolor($newwidth, $newheight);
		$background = imagecolorallocate($thumb2, 255, 255, 255);
		imagefill($thumb2, 0, 0, $background);

		$fileType = $this->FileExt($thumbname);
		switch($fileType) {
			case('gif'): $source = imagecreatefromgif($image); break;
			case('png'): $source = imagecreatefrompng($image); break;
			default: $source = imagecreatefromjpeg($image);
		}

		//tymczasowa miniaturka przed wycieciem srodka
		imagecopyresampled($thumb2, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		//wycinamy srodek
		imagecopy($thumb, $thumb2, 0, 0, $left, $top, $newwidth_dest, $newheight_dest);
		
		$thumb = $this->ImageSharpen($thumb);
		
		//zapis na dysku
		switch($fileType) {
			case('gif'): imagegif($thumb, $thumbname); break;
			case('png'): imagepng($thumb, $thumbname,9); break;
			default: imagejpeg($thumb, $thumbname,95);
		}
		return true;
	}

	public function MakeThumbSquare($image,$newwidth,$thumbname) {
		list($width, $height, $type) = getimagesize($image);
        	$newheight = round($newwidth*$height/$width);

		//obrazek docelowy
		$thumb = imagecreatetruecolor($newwidth, $newwidth);
		$background = imagecolorallocate($thumb, 255, 255, 255);
		imagefill($thumb, 0, 0, $background);
		//obrazek temp
		$thumb2 = imagecreatetruecolor($newwidth, $newheight);
		$background = imagecolorallocate($thumb2, 255, 255, 255);
		imagefill($thumb2, 0, 0, $background);

		//sprawdzamy, czy obrazek jest kwadratem, jezeli nie, to robimy wycinek kwadratowy ze srodka
		if($newheight>$newwidth) $top=round(($newheight-$newwidth)/2); else $top=0;
		if($newheight<$newwidth) $topdest=round(($newwidth-$newheight)/2); else $topdest=0;

		$fileType = $this->FileExt($thumbname);
		switch($fileType) {
			case('gif'): $source = imagecreatefromgif($image); break;
			case('png'): $source = imagecreatefrompng($image); break;
			default: $source = imagecreatefromjpeg($image);
		}

		//tymczasowa miniaturka przed wycieciem kwadratu
		imagecopyresampled($thumb2, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		//wycinamy kwadrat
		imagecopy($thumb, $thumb2, 0, $topdest, 0, $top, $newwidth, $newheight);
		
		$thumb = $this->ImageSharpen($thumb);
		
		//zapis na dysku
		switch($fileType) {
			case('gif'): imagegif($thumb, $thumbname); break;
			case('png'): imagepng($thumb, $thumbname,9); break;
			default: imagejpeg($thumb, $thumbname,95);
		}
		return true;
	}
	
	//crop image to specified width and height and add text
	public function MakeThumb5($image,$newwidth_dest,$newheight_dest,$thumbname,$text, $nrklienta) {
		list($width, $height, $type) = getimagesize($image);
        	$newheight = round($newwidth_dest*$height/$width);
		$newwidth = round($width*$newheight_dest/$height);

		//sprawdzamy, czy obrazek jest zbyt wysoki
		if($newheight>$newheight_dest) { $top=round(($newheight-$newheight_dest)/2); $newwidth=$newwidth_dest; } else { $top=0; }

		//czy nie za szeroki
		if($newwidth>$newwidth_dest) { $left=round(($newwidth-$newwidth_dest)/2); $newheight = round($newwidth*$height/$width); } else { $left=0; }

		//obrazek docelowy
		$thumb = imagecreatetruecolor($newwidth_dest, $newheight_dest);
		$background = imagecolorallocate($thumb, 255, 255, 255);
		imagefill($thumb, 0, 0, $background);
		//obrazek temp
		$thumb2 = imagecreatetruecolor($newwidth, $newheight);
		$background = imagecolorallocate($thumb2, 255, 255, 255);
		imagefill($thumb2, 0, 0, $background);

		$fileType = $this->FileExt($thumbname);
		switch($fileType) {
			case('gif'): $source = imagecreatefromgif($image); break;
			case('png'): $source = imagecreatefrompng($image); break;
			default: $source = imagecreatefromjpeg($image);
		}

		//tymczasowa miniaturka przed wycieciem srodka
		imagecopyresampled($thumb2, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		//wycinamy srodek
		imagecopy($thumb, $thumb2, 0, 0, $left, $top, $newwidth_dest, $newheight_dest);
		
		//dodajemy tło
		$white = imagecolorallocatealpha($thumb, 255, 255, 255, 60);
		//pole na napis klienta
		imagefilledrectangle($thumb, round($newwidth_dest*0.05), round($newheight_dest*0.05), round($newwidth_dest*0.95), round($newheight_dest*0.18), $white);
		
		$white = imagecolorallocatealpha($thumb, 255, 255, 255, 0);
		//pole na numer klienta
		//imagefilledrectangle($thumb, round($newwidth_dest*0.05), round($newheight_dest*0.88), round($newwidth_dest*0.45), round($newheight_dest*0.96), $white);
		//pole na numer karnetu
		imagefilledrectangle($thumb, round($newwidth_dest*0.50), round($newheight_dest*0.88), round($newwidth_dest*0.95), round($newheight_dest*0.96), $white);
		
		if($text!="") {
			//dodajemy napis
			//imagestring($thumb, 3, 10, $newheight_dest-35, $text, $black);
			$im = imagecreatetruecolor($newwidth_dest, $newheight_dest);
			//$black = imagecolorallocate($im, 0, 0, 0);
			//$pos=imagettftext($im, round((20*$newwidth_dest)/350), 0, 10, round($newheight_dest*0.97), $black, 'data/PFAmateur.ttf', $text);
			//$textwidth=$pos[4]-$pos[6];
			//$center1=intval($newwidth_dest/2);
			//$center2=intval($textwidth/2);
			//$posdest=$center1-$center2;
			$posdest=round((30*$newwidth_dest)/350);
			$black = imagecolorallocate($thumb, 0, 0, 0);		
			imagettftext($thumb, round((14*$newwidth_dest)/350), 0, $posdest, round($newheight_dest*0.14), $black, 'data/PFAmateur.ttf', $text);
		}
		
		//numer klienta
		/*
		$posdest=round((55*$newwidth_dest)/350);
		imagettftext($thumb, round((9*$newwidth_dest)/350), 0, $posdest, (round($newheight_dest*0.955)), $black, 'data/ap.ttf', 'nr. klienta: '.$nrklienta);
		*/
		
		$thumb = $this->ImageSharpen($thumb);
		
		//zapis na dysku
		switch($fileType) {
			case('gif'): imagegif($thumb, $thumbname); break;
			case('png'): imagepng($thumb, $thumbname,9); break;
			default: imagejpeg($thumb, $thumbname,95);
		}
		return true;
	}
	
	public function watermark($sourcefile, $watermarkfile, $place) {

		#
		# $sourcefile = Filename of the picture to be watermarked.
		# $watermarkfile = Filename of the 24-bit PNG watermark file.
		#
	
		//Get the resource ids of the pictures
		$watermarkfile_id = imagecreatefrompng($watermarkfile);
	
		imageAlphaBlending($watermarkfile_id, false);
		imageSaveAlpha($watermarkfile_id, true);
	
		$fileType = $this->FileExt($sourcefile);
	
		switch($fileType) {
			case('gif'):
			$sourcefile_id = imagecreatefromgif($sourcefile);
			break;
	
			case('png'):
			$sourcefile_id = imagecreatefrompng($sourcefile);
			break;
	
			default:
			$sourcefile_id = imagecreatefromjpeg($sourcefile);
		}
	
		//Get the sizes of both pix
		$sourcefile_width=imageSX($sourcefile_id);
		$sourcefile_height=imageSY($sourcefile_id);
		$watermarkfile_width=imageSX($watermarkfile_id);
		$watermarkfile_height=imageSY($watermarkfile_id);
	
		if($place=="pd") {
			$dest_x = $sourcefile_width - $watermarkfile_width - 5;
			$dest_y = $sourcefile_height - $watermarkfile_height -45;
		} elseif($place=="ld") {
			$dest_x = 5;
			$dest_y = $sourcefile_height - $watermarkfile_height -45;
		} elseif($place=="pg") {
			$dest_x = $sourcefile_width - $watermarkfile_width - 5;
			$dest_y = 5;
		} elseif($place=="lg") {
			$dest_x = 5;
			$dest_y = 5;
		}
	
		// if a gif, we have to upsample it to a truecolor image
		if($fileType == 'gif') {
			// create an empty truecolor container
			$tempimage = imagecreatetruecolor($sourcefile_width,$sourcefile_height);
	
			// copy the 8-bit gif into the truecolor image
			imagecopy($tempimage, $sourcefile_id, 0, 0, 0, 0,$sourcefile_width, $sourcefile_height);
	
			// copy the source_id int
			$sourcefile_id = $tempimage;
		}
	
		imagecopy($sourcefile_id, $watermarkfile_id, $dest_x, $dest_y, 0, 0,$watermarkfile_width, $watermarkfile_height);

		//Create a jpeg out of the modified picture
		switch($fileType) {

			// remember we don't need gif any more, so we use only png or jpeg.
			// See the upsaple code immediately above to see how we handle gifs
			case('png'):
			imagepng ($sourcefile_id, $sourcefile);
			break;

			default:
			imagejpeg ($sourcefile_id, $sourcefile);
		}

		imagedestroy($sourcefile_id);
		imagedestroy($watermarkfile_id);
	}
	
	public function GetImage($plik, $size, $echo=true) {
		$plik = str_replace(SITE_URL, '',$plik);
		if($this->ValidFormGetImage(array('plik'=>$plik, 'size'=>$size))) {
			$path = str_replace(basename($plik),'',$plik);
			$filename = basename($plik);
			$sizeTab = explode('x',$size);
			if(count($sizeTab)==1) {
				$width=intval($sizeTab[0]);
				$height=intval($sizeTab[0]);
			} elseif(count($sizeTab)==2) {
				$width=intval($sizeTab[0]);
				$height=intval($sizeTab[1]);
			}
			$preffix = $width.'x'.$height.'px_';
			
			if(file_exists($path.$preffix.$filename)) {
				if($echo) echo $path.$preffix.$filename;
				else return $path.$preffix.$filename;
			} else {
				if($height==0) {
					$this->MakeThumb($plik,$width,$path.$preffix.$filename);
				} else {
					$this->MakeThumb2($plik,$width,$height,$path.$preffix.$filename);
				}
				
				if($width>300) $this->watermark($path.$preffix.$filename, 'data/watermark.png', 'pd');
				
				if($echo) echo $path.$preffix.$filename;
				else return $path.$preffix.$filename;
			}
		} else {
			return '';
		}
	}
	
	private function ImageSharpen( $image) {
    
	    $matrix = array(
		array(-1, -1, -1),
		array(-1, 16, -1),
		array(-1, -1, -1),
	    );
	
	    $divisor = array_sum(array_map('array_sum', $matrix));
	    $offset = 0; 
	    imageconvolution($image, $matrix, $divisor, $offset);
	    
	    return $image;
	}
	
	private function ValidFormGetImage($vars) {
		$err=array();
		//check variables
		if($vars['plik']=="") $err['plik']=1;
		if($vars['size']=="") $err['size']=1;
		if(!preg_match('/^data\/(.*)\/[a-zA-Z0-9\-\_\.\/\s]+$/',$vars['plik'])) $err['plik']=1;
		if(str_replace('../','/',$vars['plik'])!=$vars['plik']) $err['plik']=1;
		if(!preg_match('/^[0-9x]+$/',$vars['size'])) $err['size']=1;

		if(count($err)==0) {
			return true;
		} else {
			//$this->error=$err;
			return false;
		} 
	}

	public function FileExt($filename)
	{
		$pi = pathinfo($filename);
		return strtolower($pi['extension']);
	}

	public function ExtValid($filename, $ext = null)
	{
		$fileExt = strtolower(trim($this->FileExt($filename)));

		if ($ext === null) $ext = "jpeg,jpg,gif,png";
		$ext = explode(',',$ext);
		foreach($ext as $knownExt)
			if (strtolower(trim($knownExt)) == $fileExt) return true;

		return false;
	}

	public function getMimeType($file_path)
	{
		$mtype = '';
		if (function_exists('mime_content_type')){
		$mtype = mime_content_type($file_path);
		}
		else if (function_exists('finfo_file')){
		$finfo = finfo_open(FILEINFO_MIME);
		$mtype = finfo_file($finfo, $file_path);
		finfo_close($finfo);
		}
		if ($mtype == ''){
		$mtype = "application/force-download";
		}
		return $mtype;
	}

	public function getIcon($file) {
		if(filetype($file) == "dir") return "dir.png";
		$fileExt = strtolower(trim($this->FileExt($file)));
		if(in_array($fileExt, array("jpg","jpeg","gif","png"))) return "image.png";
		if(in_array($fileExt, array("avi","mpeg","mpg","mov","swf"))) return "media.png";
		if(in_array($fileExt, array("pdf"))) return "pdf.png";
		if(in_array($fileExt, array("txt","doc","odt","rtf"))) return "doc.png";
		if(in_array($fileExt, array("zip","rar","tar"))) return "arch.png";
		if(in_array($fileExt, array("ttf"))) return "ttf.png";
		return "misc.png";
	}

	//delete dir with content
	public function SureRemoveDir($dir, $DeleteMe) {
	    if(!$dh = @opendir($dir)) return;
	    while (false !== ($obj = readdir($dh))) {
		if($obj=='.' || $obj=='..') continue;
		if (!@unlink($dir.'/'.$obj)) $this->SureRemoveDir($dir.'/'.$obj, true);
	    }

	    closedir($dh);
	    if ($DeleteMe){
		@rmdir($dir);
	    }
	}

	//funkcja do wysyłania zwykłych maili
	public function sendMailPlain($email, $temat, $tresc, $nadawca) {
	$charset='UTF-8';
	$temat="=?$charset?B?".base64_encode($temat)."?=\n";
	$headers="From: $nadawca\n"
	    . "Content-Type: text/html; charset=$charset; format=flowed\n"
	    . "MIME-Version: 1.0\n"
	    . "Content-Transfer-Encoding: 8bit\n"
	    . "X-Mailer: PHP\n";
		if(mail($email, $temat, $tresc,$headers)) return true; else return false;
	}

	public function PaginateSimple($res, $strcount, $s, $pole = "id") {

		if($s>0) $s=$s; else $s=1;
		$s--;
		$min=$s*$strcount;

		//ilosc imprez
		$ileNewsow=count($res);
		//ilosc stron
		$ilestron=$ileNewsow/$strcount;
		if($ilestron-round($ilestron)>0) $ilestron=round($ilestron)+1; else $ilestron=round($ilestron);
		//tablica stron do linkow
		$tabStr=array();
		for($i=0;$i<$ilestron;$i++) $tabStr[$i]=$i+1;
		//wycinek tablicy do pokazania na stronie
		$res2=array();
		for($i=$min;$i<($strcount+$min);$i++) if($res[$i][$pole]>0) $res2[]=$res[$i];
		
		//wycinka w numerach stron
		$strony = array();
		if($ilestron<=10) {
			$strony = $tabStr;
		} else {
			
		
			$ilezdolu = 0;
			$cuttop = true;
			$cutbottom = true;
			
			if($s-4>0) $ilewdol = 4; else { $ilewdol = 4-(4-$s); }
			if($s<6) { $ilewdol = $s; $cutbottom=false; }
			$ilezdolu = 4-$ilewdol; if($ilezdolu<0) $ilezdolu=0;

			if($s+4+$ilezdolu < $ilestron) $ilewgore = (5+$ilezdolu); else { $ilewgore = $ilestron-$s; $cuttop=false; }
			if($s>=$ilestron-6) { $cuttop=false; $ilewgore=$ilestron-$s; $ilewdol+=(5-$ilewgore-$ilezdolu); }
			
			
			if($cutbottom) {
				$strony[]=$tabStr[0]; //pierwszy element
				$strony[]="...";
			} 
			
			for($i=($s-$ilewdol);$i<($s+$ilewgore);$i++) $strony[]=$tabStr[$i];
			
			if($cuttop) {
				$strony[]="...";
				$strony[]=$tabStr[$ilestron-1]; //ostatni element
			}
			
			
		}

		return array("res"=>$res2, "tabStr"=>$strony);
	}
	
	public function Paginate($dane, $strcount, $s=1, $dopisek="", $zapisek="", $btnprev="&lt; poprzednia", $btnnext="następna &gt;", $classon="active", $idlist="pagesnav", $classprev="pagesprev", $classnext="pagesnext", $siteUrl="") {

		if($s>0) $s=$s; else $s=1;
		$s--;
		$min=$s*$strcount;

		############## DO PODZIALU NA STRONY ################
		//ilosc prac
		$ileNewsow=count($dane);
		//ilosc stron
		$ilestron=$ileNewsow/$strcount;
		if($ilestron-round($ilestron)>0) $ilestron=round($ilestron)+1; else $ilestron=round($ilestron);
		//wybrana strona
		$zakresOd=(($strcount*$s)+1);
		$zakresDo=($strcount*($s+1)); if($zakresDo>$ileNewsow) $zakresDo=$ileNewsow;
		//$smarty->assign("dataZakres", array("od"=>$zakresOd, "do"=>$zakresDo));
		//wycinek tablicy do pokazania na stronie
		$res2=array();
		for($i=$min;$i<($strcount+$min);$i++) if($dane[$i][id]>0) { $res2[]=$dane[$i]; }

		if($ileNewsow>0) {
			//tworzenie ... w podziale na strony w zaleznosci od ich ilosci
			$strString="<ul id=\"".$idlist."\">"; $prog_stron=10; $s++; $ile_promien_sr=floor($prog_stron/2);

			//przycisk prev
			if($s==1) $strString.="";
			else $strString.="<li class=\"".$classprev."\"><a href=\"".$siteUrl.$dopisek.($s-1).$zapisek."\">".$btnprev."</a></li>";
			//tworzenie standardowej listy stron
			if($ilestron<=$prog_stron) {
			for($i=1;$i<=$ilestron;$i++) {
			$strString.="<li";
			if($i==$s) $strString.=" class=\"".$classon."\""; 
			$strString.="><a href=\"".$siteUrl.$dopisek.$i.$zapisek."\">" . $i . "</a></li>";
			}
			}
			//tworzenie listy stron z ... gdzie wybrana jest strona nie ostatnia z pierwszego przedzialu
			else if($ilestron>$prog_stron && $s>=1 && $s<($prog_stron-1)) {
			//strony z pierwszej grupy
			for($i=1;$i<=($prog_stron-1);$i++) {
			$strString.="<li";
			if($i==$s) $strString.=" class=\"".$classon."\"";
			$strString.="><a href=\"".$siteUrl.$dopisek.$i.$zapisek."\">" . $i . "</a></li>";
			}
			//...
			$strString.="<li><a href=\"#\">...</a></li>";
			//ostatnia strona
			$strString.="<li";
			if($i==$s) $strString.=" class=\"".$classon."\"";
			$strString.="><a href=\"".$siteUrl.$dopisek.$ilestron.$zapisek."\">" . $ilestron . "</a></li>";
			}

			//tworzenie listy stron z ... gdzie wybrana jest strona spoza promienia od pierwszej
			else if($ilestron>$prog_stron && $s>($ile_promien_sr-1) && $s<($ilestron-$prog_stron+2)) {
			//strona pierwsza
			$strString.="<li";
			if(1==$s) $strString.=" class=\"".$classon."\"";
			$strString.="><a href=\"".$siteUrl.$dopisek."1".$zapisek."\">" . 1 . "</a></li>";
			//...
			$strString.="<li><a href=\"#\">...</a></li>";
			//strony środkowe ze środkiem w punkcie $s i ilosci stron w promieniu
			for($i=($s-$ile_promien_sr+1);$i<=($s+$ile_promien_sr-1);$i++) {
			$strString.="<li";
			if($i==$s) $strString.=" class=\"".$classon."\"";
			$strString.="><a href=\"".$siteUrl.$dopisek.$i.$zapisek."\">" . $i . "</a></li>";
			}
			//...
			$strString.="<li><a href=\"#\">...</a></li>";
			//ostatnia strona
			$strString.="<li";
			if($i==$s) $strString.=" class=\"".$classon."\"";
			$strString.="><a href=\"".$siteUrl.$dopisek.$ilestron.$zapisek."\">" . $ilestron . "</a></li>";
			}

			//tworzenie listy stron z ... gdzie wybrana jest strona spoza promienia od ostatniej
			else if($ilestron>$prog_stron && $s<($ilestron-$ile_promien_sr+1)) {
			//strona pierwsza
			$strString.="<li";
			if(1==$s) $strString.=" class=\"".$classon."\"";
			$strString.="><a href=\"".$siteUrl.$dopisek."1".$zapisek."\">" . 1 . "</a></li>";
			//...
			$strString.="<li><a href=\"#\">...</a></li>";
			//strony środkowe ze środkiem w punkcie $s i ilosci stron w promieniu
			for($i=($s-$ile_promien_sr+1);$i<=($s+$ile_promien_sr-1);$i++) {
			$strString.="<li";
			if($i==$s) $strString.=" class=\"".$classon."\"";
			$strString.="><a href=\"".$siteUrl.$dopisek.$i.$zapisek."\">" . $i . "</a></li>";
			}
			//...
			$strString.="<li><a href=\"#\">...</a></li>";
			//ostatnia strona
			$strString.="<li";
			if($i==$s) $strString.=" class=\"".$classon."\"";
			$strString.="><a href=\"".$siteUrl.$dopisek.$ilestron.$zapisek."\">" . $ilestron . "</a></li>";
			}

			//tworzenie listy stron, gdzie wybrana strona jest z ostatniego przedzialu
			else if($ilestron>$prog_stron && $s>=($ilestron-$prog_stron)) {
			//strona pierwsza
			$strString.="<li";
			if(1==$s) $strString.=" class=\"".$classon."\"";
			$strString.="><a href=\"".$siteUrl.$dopisek."1".$zapisek."\">" . 1 . "</a></li>";
			//...
			$strString.="<li><a href=\"#\">...</a></li>";
			//ostatnia grupa strony
			for($i=($ilestron-$prog_stron+2);$i<=$ilestron;$i++) {
			$strString.="<li";
			if($i==$s) $strString.=" class=\"".$classon."\"";
			$strString.="><a href=\"".$siteUrl.$dopisek.$i.$zapisek."\">" . $i . "</a></li>";
			}
			}
			//przycisk next
			if($s==$ilestron) $strString.="";
			else $strString.="<li class=\"".$classnext."\"><a href=\"".$siteUrl.$dopisek.($s+1).$zapisek."\">".$btnnext."</a></li>";
		}
		$strString.="</ul>";

		return array("res"=>$res2, "strString"=>$strString);
	}
	
	public function msort($array, $id="id", $sort_ascending=true) {
		$temp_array = array();
		while(count($array)>0) {
		$lowest_id = 0;
		$index=0;
		foreach ($array as $item) {
			if (isset($item[$id])) {
					if ($array[$lowest_id][$id]) {
			if ($item[$id]<$array[$lowest_id][$id]) {
				$lowest_id = $index;
			}
			}
					}
			$index++;
		}
		$temp_array[] = $array[$lowest_id];
		$array = array_merge(array_slice($array, 0,$lowest_id), array_slice($array, $lowest_id+1));
		}
			if ($sort_ascending) {
		return $temp_array;
			} else {
			return array_reverse($temp_array);
			}
	}
	
	//repair serialized
	public function repairSerializedArray($serialized)
	{
		$tmp = preg_replace('/^a:\d+:\{/', '', $serialized);
		return $this->repairSerializedArray_R($tmp); // operates on and whittles down the actual argument
	}
	
	private function repairSerializedArray_R(&$broken)
	{
		// array and string length can be ignored
		// sample serialized data
		// a:0:{}
		// s:4:"four";
		// i:1;
		// b:0;
		// N;
		$data		= array();
		$index		= null;
		$len		= strlen($broken);
		$i			= 0;
		
		while(strlen($broken))
		{
			$i++;
			if ($i > $len)
			{
				break;
			}
			
			if (substr($broken, 0, 1) == '}') // end of array
			{
				$broken = substr($broken, 1);
				return $data;
			}
			else
			{
				$bite = substr($broken, 0, 2);
				switch($bite)
				{	
					case 's:': // key or value
						$re = '/^s:\d+:"([^\"]*)";/';
						if (preg_match($re, $broken, $m))
						{
							if ($index === null)
							{
								$index = $m[1];
							}
							else
							{
								$data[$index] = $m[1];
								$index = null;
							}
							$broken = preg_replace($re, '', $broken);
						}
					break;
					
					case 'i:': // key or value
						$re = '/^i:(\d+);/';
						if (preg_match($re, $broken, $m))
						{
							if ($index === null)
							{
								$index = (int) $m[1];
							}
							else
							{
								$data[$index] = (int) $m[1];
								$index = null;
							}
							$broken = preg_replace($re, '', $broken);
						}
					break;
					
					case 'b:': // value only
						$re = '/^b:[01];/';
						if (preg_match($re, $broken, $m))
						{
							$data[$index] = (bool) $m[1];
							$index = null;
							$broken = preg_replace($re, '', $broken);
						}
					break;
					
					case 'a:': // value only
						$re = '/^a:\d+:\{/';
						if (preg_match($re, $broken, $m))
						{
							$broken			= preg_replace('/^a:\d+:\{/', '', $broken);
							$data[$index]	= $this->repairSerializedArray_R($broken);
							$index = null;
						}
					break;
					
					case 'N;': // value only
						$broken = substr($broken, 2);
						$data[$index]	= null;
						$index = null;
					break;
				}
			}
		}
		
		return $data;
	}
	
	/*data storage */
	public function GetDir($id, $format='array') {
		$arr = str_split(strval($id));
		if($format == 'array') return $arr;
		if($format == 'text') {
			if(count($arr)>0) return implode("/", $arr);
			else return "";
		}
		return false;
	}
}
?>