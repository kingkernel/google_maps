<?php

 class googlemaps{
 /*
data criação: 11/11/2017
 */
 	private $key;						//sua key do google maps
 	public $functionname;				// o nome da função
 	public $idmap;						// o id da div que vai conter o mapa
 	public $zoom;						// tamanho do zoom
 	public $points = array();			// array com marcadores
 	public $position = array();			// posição inicial do mapa


 	public function __construct(){
 		if(!isset($this->zoom)){$this->zoom=15;};
 	}
 	public function render(){
 		echo '<script src="https://maps.googleapis.com/maps/api/js?key='.$this->key.'&callback='.$this->functionname.'&language=PT-BR&region=BR" async defer></script>';
 	}
 	public function mountjs(){
 		echo 'function '.$this->functionname.'(){var map = new google.maps.Map(document.getElementById(\''.$this->idmap.'\'), {zoom: '.$this->zoom.', center: {lat: '.$this->position["lat"].', lng: '.$this->position["lng"].'}});';
        foreach ($this->points as $key => $value) {
        	$value->render();
        };
        echo '};';
 	}
 }
 class mapspoint{
/*
data criação: 11/11/2017
 */
 	public $mapa;				// a qual mapa esse ponto pertence
 	public $icon;				// icone que será usado... recomento imagens 48X48
 	public $name;				// ainda sem utilização... mas acho que será preciso
 	public $title;				// texto para quando passar o mouse
 	public $somacontent;		// ainda sem utilização... mas acho que será preciso
 	public $position;			//array com latitude e longitude [lat], [lng]
 	public $balloncontent;		// conteudo do balão de descrição
 	public $variablename;		// nome da variavel que vai conter o balão
 	public $exibeballon;


 	public function __construct(){
 		if(!isset($this->icon)){$this->icon='\'\'';};if(!isset($this->title)){$this->title='\'\'';};
 		if(!isset($this->variablename)){$this->variablename='descri';};
 		if(!isset($this->balloncontent)){$this->balloncontent='<div><h1>hellou!</h1></div>';};

 	}
 	public function render(){
 		echo 'var marker'.$this->variablename.' = new google.maps.Marker({position: {lat: '.$this->position["lat"].', lng: '.$this->position["lng"].'}, map: '.$this->mapa.', title: \''.$this->title.'\',icon: \''.$this->icon.'\'});';
		echo 'var '.$this->variablename.' = \''.$this->balloncontent.'\';';
		if(isset($this->exibeballon)){
			echo 'var infow_'.$this->variablename.' = new google.maps.InfoWindow({content: '.$this->variablename.'}); marker'.$this->variablename.'.addListener(\'click\', function(){infow_'.$this->variablename.'.open('.$this->mapa.', marker'.$this->variablename.');});';	
   		};
 	}

 }

 // exemplo de uso...
 //  <div id="map" ></div> 			---> o div que conterá o mapa esse id deve ser passado pra classe com  idmap
 
 //declarando o mapa
$maps = new googlemaps;
$maps->functionname = "initMap";
$maps->idmap = "map";
$maps->position = array('lat' => "-0.035446", 'lng'=>"-51.1822884");

	//declarando os pontos
	$ponto1 = new mapspoint;
	$ponto1->mapa = "map"; 			//------> qual mapa pertence esse ponto...
	$ponto1->title = "ponto 1";
	$ponto1->position = array("lat"=>"-0.035446", "lng"=>"-51.1822884");

	$ponto2 = new mapspoint;
	$ponto2->mapa = "map"; 			//------> qual mapa pertence esse ponto...
	$ponto2->title = "ponto 2";
	$ponto2->position = array("lat"=>"-0.02673", "lng"=>"-51.17817");

	$ponto3 = new mapspoint;
	$ponto3->mapa = "map"; 			//------> qual mapa pertence esse ponto...
	$ponto3->title = "ponto 3";
	$ponto3->position = array("lat"=>"-0.03355", "lng"=>"-51.17487");
	
	//adicionando os pontos no mapa
	$maps->points = array($ponto1, $ponto2, $ponto3);

// chamando o javascript	
$maps->mountjs();
// fazendo o mapa aparecer na tela
$maps->render()
?>
