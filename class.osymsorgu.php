<?php
if($_POST){

	$tc = $_POST['tckno'];







		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => "https://smis.osym.gov.tr/KurumGorevli/SorgulamaEkrani",
			CURLOPT_POST => 0,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_HTTPHEADER => array(
				'Accept: */*',
				'Accept-Language: tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7',
				'Connection: keep-alive',
				'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
				'Cookie: __RequestVerificationToken="güvenli olan request verifiaction token :)"; NSC_TNJT_TTM=ffffffff090e9c0f45525d5f4f58455e445a4a423660; .osymauth=osym auth bilgisi',
				'Host: smis.osym.gov.tr',
				'Origin: https://smis.osym.gov.tr',
				'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="100", "Google Chrome";v="100"',
				'sec-ch-ua-mobile: ?0',
				'sec-ch-ua-platform: "Windows"',
				'Sec-Fetch-Dest: empty',
				'Sec-Fetch-Mode: cors',
				'Sec-Fetch-Site: same-origin',
				'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.88 Safari/537.36',
				'X-Requested-With: XMLHttpRequest',
			),
		));
		$fim = curl_exec($ch);


		$getreqvtoken = explode('__RequestVerificationToken" type="hidden" value="', $fim);
		$getreqvtoken = explode('"', $getreqvtoken[1]);


	 	$reqvtoken = $getreqvtoken[0];

		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => "https://bmis.osym.gov.tr/KurumGorevli/Sorgula",
			CURLOPT_POST => 1,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_HTTPHEADER => array(
				'Accept: */*',
				'Accept-Language: tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7',
				'Connection: keep-alive',
				'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
				'Cookie: __RequestVerificationToken=güvenli olan request verifiaction token :); NSC_TNJT_TTM=ffffffff090e9c0f45525d5f4f58455e445a4a423660; .osymauth=osym auth bilgisi',
				'Host: smis.osym.gov.tr',
				'Origin: https://smis.osym.gov.tr',
				'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="100", "Google Chrome";v="100"',
				'sec-ch-ua-mobile: ?0',
				'sec-ch-ua-platform: "Windows"',
				'Sec-Fetch-Dest: empty',
				'Sec-Fetch-Mode: cors',
				'Sec-Fetch-Site: same-origin',
				'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.88 Safari/537.36',
				'X-Requested-With: XMLHttpRequest',
			),
			CURLOPT_POSTFIELDS => '{"TcKimlikNo":"'.$tc.'","__RequestVerificationToken":"'.$reqvtoken.'"}'
		));
		 $fim = curl_exec($ch);
	
	
		$yanit = curl_getinfo($ch);
	
		$yanit = $yanit['http_code'];
	
	
		if($yanit === 200){
	
			$parcalabunuamcik = explode('var kurumGorevliKayitViewModel = ko.mapping.fromJS(', $fim);
			$parcalabunuamcik = explode(',kuru', $parcalabunuamcik[1]);
		
			$getirparcaladigini = $parcalabunuamcik[0];
		
		
		
			$json = json_decode($getirparcaladigini, true);
		

		
		
			$uyruk = $json['KimlikBilgiViewModel']['UyrukDetailedString'];
		
			$tcknoo = $json['KimlikBilgiViewModel']['KimlikBilgi']['TcKimlikNoRo'];
		
			$adsoyad = $json['KimlikBilgiViewModel']['AdSoyad'];

			$babaadi = $json['KimlikBilgiViewModel']['KimlikBilgi']['BabaAdi'];

			$anneadi = $json['KimlikBilgiViewModel']['KimlikBilgi']['AnneAdi'];

			$dogumyeri = $json['KimlikBilgiViewModel']['KimlikBilgi']['DogumYeri'];

			$dogumtarihi = $json['KimlikBilgiViewModel']['DogumTarihiString'];
		
			$adres = $json['AdresIletisimBilgi']['AdresIletisim']['Adres'];
		
			$il = $json['AdresIletisimBilgi']['AdresIletisim']['Il']['AdRo'];
		
			$ilce = $json['AdresIletisimBilgi']['AdresIletisim']['Ilce']['AdRo'];
		
			$tckphoto = $json['KimlikBilgiViewModel']['FotografBilgi']['Data'];
		
			if(!isset($tckphoto)){
				
				echo '
			
				<tr>
				<td><b>'.$tcknoo.'</b>
				</td>
				<td>'.$adsoyad.'</td>
				<td>'.$babaadi.'</td>
				<td>'.$anneadi.'</td>
				<td>'.$dogumyeri.'</td>
				<td>'.$dogumtarihi.'</td>
				<td><span class="text-muted">'.$adres.'</span>
				</td>
				<td>'.$il.'</td>
				<td>'.$ilce.'</td>
				<td>Fotoğrafı Mevcut Değil</td>
				<td><span class="badge badge-danger">'.$uyruk.'</span>
				</td>
				</td>
			</tr>
				
				';
		
			}else{
		
				$tckphoto = '<a href="data:image/jpeg;base64,'.$tckphoto.'"><img width="50" weight="100" src="data:image/jpeg;base64,'.$tckphoto.'"></a>';
		
		
				echo '
				
				<tr>
				<td><b>'.$tcknoo.'</b>
				</td>
				<td>'.$adsoyad.'</td>
				<td>'.$babaadi.'</td>
				<td>'.$anneadi.'</td>
				<td>'.$dogumyeri.'</td>
				<td>'.$dogumtarihi.'</td>
				<td><span class="text-muted">'.$adres.'</span>
				</td>
				<td>'.$il.'</td>
				<td>'.$ilce.'</td>
				<td>'.$tckphoto.'</td>
				<td><span class="badge badge-danger">'.$uyruk.'</span>
				</td>
				</td>
			</tr>
				
				';
		
			}
	
		}else{
	
			echo '
				
			<tr>
			<td><b>Bağlantı problemi oluştu</b>
			</td>
			<td></td>
			<td><span class="text-muted"></span>
			</td>
			<td></td>
			<td></td>
			<td></td>
			<td><span class="badge badge-danger"></span>
			</td>
			</td>
		</tr>
			
			';
	
		}













	
}

?>