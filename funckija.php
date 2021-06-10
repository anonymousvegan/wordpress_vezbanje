add_filter('wp_handle_upload_prefilter','tc_handle_upload_prefilter');
function tc_handle_upload_prefilter($file)
{
	if(!current_user_can('administrator'))
    {
		//veličina slike u bajtovima:
		$slika = $file;
		$ime_slike = $slika["name"];
		$tmp=$slika["tmp_name"];
		$velicina = $file["size"];
		$greska= $slika["error"];
		$tip= $slika["type"];
		$ekstenzija= strtolower(end(explode(".", $ime_slike)));
		$dozvoljene_ekstenzije = array("webp");
		#provera ekstenzije
		if(in_array($ekstenzija, $dozvoljene_ekstenzije)){
			#provera veličine slike  (byte)
			if($velicina<51200){
				#provera rezolucije slike (mora da je 700x700)
				$velicina_slike = getimagesize($tmp);
				$sirina = $velicina_slike[0];
				$visina = $velicina_slike[1];
				if($sirina==800 && $visina==600){
					$poruka = "RADI";
					return $file;
				}
				else{
					return array("error"=>"Greška! Slika nije odgovarajuće rezolucije!");
				}
			}
			else{
				return array("error"=>"Greška! Slika mora biti manja od 50KB");
			}
		}
		else{
			return array("error"=>"Greška! Slika  nije odgovarajućeg formata!");
		}
	}
    else{
	    return  $file;
    }
}