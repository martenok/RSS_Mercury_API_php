
<?php
function getVoog($feed_url){
/**
*Võtab RSS voost lingi artiklile
*Saadab saadud lingi läbi Mercury API 
*Näitab iga lingi taga olnud sisust u. esimesed 350 tähemärki
*/
	
	$xml = simplexml_load_file($feed_url); 

	$m = 0; //Muutuja modaal akende identifitseerimiseks
	
	foreach($xml->channel->item as $entry) {
	//Käib läbi kõik RSS voost saadud uudised
	
		$link = $entry->link; //Võtab artiklile viitava lingi
		
		$html = ""; 
		
		//Võlukood, mis saadud GitHUBist ja mis saadab lingi läbi mercury API kasutades cURL-i
		/**
		 * Created by PhpStorm.
		 * User: Rees Clissold
		 * Date: 13/11/2016
		 * Time: 20:46
		 */
		// Proof of concept
		// TODO: Rewrite this in JavaScript using an AJAX HTTP Request
		
		$ch = curl_init();
		$api_key = file_get_contents('api.key');
		$request_headers = array();
		$request_headers[] = 'x-api-key: ' . $api_key;
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_URL, 'https://mercury.postlight.com/parser?url=' . $link);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
		
		$output = json_decode(curl_exec($ch));
		curl_close($ch);
		//Võlukoodi lõpp
		
		$title = $output->title;
		$content = $output->content;
		
		
		if ($output->date_published == ""){
			$kuup = "Väga vana";
		}else {
			$kuup = date('Y-m-d', strtotime($output->date_published));	
		}		
		
		
		$image = $output->lead_image_url;
		
		/**
		*Kontroll, kas artiklil on mingi sisu
		*strip_tags() puhastab stringi HTML ja PHP tagidest
		*/		
		if (strlen(strip_tags($content)) > 0) {

			//Lehitseja aknale sisu loomine

			$html .= "<div class='col-sm-4'> ";	
			$html .= "<div class='well well-sm'> ";
			
			$html .= "$kuup";

			$m++; //Modaalakna unikaalne id	
			
			//link modaalaknale			
			$html .= "<a href= '#' data-target=\"#$m\" data-toggle=\"modal\"> <h3>'$title'</h3> </a>";
			
			//Pilt lehitsejale ainult siis, kui pildi link terve
			if (url_exists($image)){
				$html .= "<img src='$image' class='img-thumbnail' alt='$title' 	style='float:right;width:50%;border:0;'>";
			}
			
			//Lühendatud eelvaate sisu tegemine
			$n = 350; //eelvaate sisu pikkus tähtedes
			
			$eelVaade = strtok(strip_tags($content), "."); //strtok() annab stringi kuni eraldajani
			for ($x = 0; $x <= 2; $x++) { //Võtan 3 lauset, eeldusel, et lause lõppeb punktiga
				$eelVaade .= strtok(".") . ".";
			}
			
			if (strlen($eelVaade) > $n) { //Kui sisu pikem kui vaja, siis tee viimase tühiku pealt lühemaks
				$description = substr($eelVaade, 0, strripos(substr($eelVaade, 0, $n), " ")) . "...";
			}else {
				$description = $eelVaade;
			}			
			$html .= "$description";
			
			//modaalakna sisu

			$html .= "
				<div id='$m' class='modal fade'>
					<div class='modal-dialog'>
						<div class='modal-content'>
							<div class='modal-header'>
								<button type='button' class='close' data-dismiss='modal' >&times;</button>
								<h2>'$title'</h2>
							</div>
							<div class='modal-body'>
							   $content

							</div>

						</div>
					</div>  
				</div>";
				
			
			$html .= "</div>";
			$html .= "</div>";
			
			echo $html; //saadab browserile sisu
		}

	}

}

//Funktsioon mis kontrollib, kas pildi lingilt tuleb pilt
function url_exists($url) {
    $hdrs = @get_headers($url);

    return is_array($hdrs) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$hdrs[0]) : false;
}

?>