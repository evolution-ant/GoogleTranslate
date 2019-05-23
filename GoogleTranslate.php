<?php 

/*
* Author: Douglas Henrique
* Github: https://github.com/douglashsilva/
*/

class GoogleTranslate {

	// Supported Languages
	private $supported = [
	  "Afrikaans" => "af",
	  "Albanian" => "sq",
	  "Amharic" => "am",
	  "Arabic" => "ar",
	  "Armenian" => "hy",
	  "Azeerbaijani" => "az",
	  "Basque" => "eu",
	  "Belarusian" => "be",
	  "Bengali" => "bn",
	  "Bosnian" => "bs",
	  "Bulgarian" => "bg",
	  "Catalan" => "ca",
	  "Cebuano" => "ceb",
	  "Chinese" => "zh-CN",
	  "Corsican" => "co",
	  "Croatian" => "hr",
	  "Czech" => "cs",
	  "Danish" => "da",
	  "Dutch" => "nl",
	  "English" => "en",
	  "Esperanto" => "eo",
	  "Estonian" => "et",
	  "Finnish" => "fi",
	  "French" => "fr",
	  "Frisian" => "fy",
	  "Galician" => "gl",
	  "Georgian" => "ka",
	  "German" => "de",
	  "Greek" => "el",
	  "Gujarati" => "gu",
	  "Haitian Creole" => "ht",
	  "Hausa" => "ha",
	  "Hawaiian" => "haw",
	  "Hebrew" => "he",
	  "Hindi" => "hi",
	  "Hmong" => "hmn",
	  "Hungarian" => "hu",
	  "Icelandic" => "is",
	  "Igbo" => "ig",
	  "Indonesian" => "id",
	  "Irish" => "ga",
	  "Italian" => "it",
	  "Japanese" => "ja",
	  "Javanese" => "jw",
	  "Kannada" => "kn",
	  "Kazakh" => "kk",
	  "Khmer" => "km",
	  "Korean" => "ko",
	  "Kurdish" => "ku",
	  "Kyrgyz" => "ky",
	  "Lao" => "lo",
	  "Latin" => "la",
	  "Latvian" => "lv",
	  "Lithuanian" => "lt",
	  "Luxembourgish" => "lb",
	  "Macedonian" => "mk",
	  "Malagasy" => "mg",
	  "Malay" => "ms",
	  "Malayalam" => "ml",
	  "Maltese" => "mt",
	  "Maori" => "mi",
	  "Marathi" => "mr",
	  "Mongolian" => "mn",
	  "Myanmar" => "my",
	  "Nepali" => "ne",
	  "Norwegian" => "no",
	  "Nyanja" => "ny",
	  "Pashto" => "ps",
	  "Persian" => "fa",
	  "Polish" => "pl",
	  "Portuguese" => "pt",
	  "Punjabi" => "pa",
	  "Romanian" => "ro",
	  "Russian" => "ru",
	  "Samoan" => "sm",
	  "Scots Gaelic" => "gd",
	  "Serbian" => "sr",
	  "Sesotho" => "st",
	  "Shona" => "sn",
	  "Sindhi" => "sd",
	  "Sinhala" => "si",
	  "Slovak" => "sk",
	  "Slovenian" => "sl",
	  "Somali" => "so",
	  "Spanish" => "es",
	  "Sundanese" => "su",
	  "Swahili" => "sw",
	  "Swedish" => "sv",
	  "Tagalog" => "tl",
	  "Tajik" => "tg",
	  "Tamil" => "ta",
	  "Telugu" => "te",
	  "Thai" => "th",
	  "Turkish" => "tr",
	  "Ukrainian" => "uk",
	  "Urdu" => "ur",
	  "Uzbek" => "uz",
	  "Vietnamese" => "vi",
	  "Welsh" => "cy",
	  "Xhosa" => "xh",
	  "Yiddish" => "yi",
	  "Yoruba" => "yo",
	  "Zulu" => "zu"
	];

	// Google Translate Server
	private $server = "https://translate.googleapis.com";

	// Selected Language
	private $language;

	// Default Language (English)
	public function __construct($language = "en"){
		// Check language code is supported
		$this->language = $this->check($language);
	}

	// Check Language Selected
	private function check($language){
		return in_array($language, array_values($this->supported)) ? $language : false;
	}

	// Translate Language
	public function translate($string){
		if($this->language !== false){
			// Request Google for translate 
			$ch = curl_init();
			curl_setopt_array($ch, [
				CURLOPT_URL => $this->server."/translate_a/single?client=gtx&sl=auto&tl=".$this->language."&dt=t&format=html",
				CURLOPT_HTTPHEADER => ["User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.157 Safari/537.36"],
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_CONNECTTIMEOUT => 0,
				CURLOPT_TIMEOUT => 10,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => http_build_query(["q" => $string]),
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_VERBOSE => true
	 		]);
	 		$data = curl_exec($ch);
	 		curl_close($ch);
	 		// Answer Comes In Json 
	 		$data = json_decode($data, true);
	 		$data = array_shift($data);
	 		$length = count($data);
	 		// Check Response
	 		if($length >= 1){
	 			// Result filter for HTML text input
	 			for($i = 0; $i < $length; $i++){
	 				$data[$i] = join(array_filter(array_map(function($value,$index){
	 					return $index === 0 ? (preg_match("/<((?=!\-\-)!\-\-[\s\S]*\-\-|((?=\?)\?[\s\S]*\?|((?=\/)\/[^.\-\d][^\/\]\'\"[!#$%&()*+,;<=>?@^`{|}~ ]*|[^.\-\d][^\/\]\'\"[!#$%&()*+,;<=>?@^`{|}~ ]*(?:\s[^.\-\d][^\/\]\'\"[!#$%&()*+,;<=>?@^`{|}~ ]*(?:=(?:\"[^\"]*\"|\'[^\']*\'|[^\'\"<\s]*))?)*)\s?\/?))>/mi", $value) ? preg_replace("/<\/ /mi", "</", $value) : $value) : null;
	 				}, $data[$i], array_keys($data[$i]))));
	 			}
	 			$data = join($data);
	 			return $data;
	 		}
	 		return "Error Translating Text (".$this->language."): ".$string."";
		}
		return "Language Code (".$this->language.") Not Supported!";
	}
}

?>
