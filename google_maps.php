<?php
class googlemaps{
 /*
	Data criação: 		11/11/2017
	última Alteração: 	12/11/2017
	Autor: 				Daniel J. Santos
	Nome Classe: 		googlemaps
	versão: 			0.02

-- ################################################################################################
Atributos: 
		key 			[private]		A key de usuário do google maps obrigatorio agora.
		functionName 	[public]		O nome da função que iniciará o mapa .
		idmap			[public] 		O id da div que conterá o mapa.
		zoom 			[public]		O zoom do mapa.. padrão é 15
		position 		[public] 		A posição inicial do centro do mapa. array com 2 ->
										<- argumentos. "lat" e "lng" que são latitude e longitude
		points 			[public] 		Array contendo os objetos que são os pontos no mapa.

Métodos:
		MountJs()		[public]		Método encarregado de retornar o javascipt para ser 
										renderizado o mapa na tela
-- ################################################################################################
 */
 	private $key;						// string
 	public $functionName;				// string
 	public $idmap;						// string
 	public $zoom;						// int
 	public $position = array();			// array
 	public $points = array();			// array


 	public function __construct($this->key){
 		if(!isset($this->zoom)){$this->zoom=15;};
 	}
/*
-- ################################################################################################
Método: mountjs
-- ################################################################################################
*/
 	public function mountjs(){
 		echo '<script type="text/javascript">function '.$this->functionName.'(){var map = new google.maps.Map(document.getElementById(\''.$this->idmap.'\'), {zoom: '.$this->zoom.', center: {lat: '.$this->position["lat"].', lng: '.$this->position["lng"].'}});';
        foreach ($this->points as $key => $value) {
        	$value->render();
        };
        echo '};</script><script src="https://maps.googleapis.com/maps/api/js?key='.$this->key.'&callback='.$this->functionName.'&language=PT-BR&region=BR" async defer></script>';
 	}
 }
 // <-- fim da classe googlemaps -->
 class mapspoint{
/*
	Data criação: 		11/11/2017
	última Alteração: 	12/11/2017
	Autor: 				Daniel J. Santos
	Nome Classe: 		googlemaps
	versão: 			0.02

-- ################################################################################################
Atributos:
		mapa 			[public]		Qual mapa pertence o objeto
		icon 			[public]		A image que será mostrada no mapa. Recomendamos no tamanho ->
										<- máximo de 48X48, embora qualquer tamanhom seja aceito
		variablename 	[public]		O nome do objeto para diferenciar nos eventos
		title 			[public]		Texto (alt) que aparece se passar o mouse sobre o ponto
		position 		[public] 		Posição do objeto no mapa. array com latitude[lat] e ->
										<- longitude [lng].
		balloncontent	[public] 		Conteudo em HTML do balão, caso o usuário clique no ponto ->
										<- do mapa
		exibeballon		[public] 		caso seja true, exibe o balão se o ponto for clicado.
-- ################################################################################################
 */
 	public $mapa;						// string
 	public $icon;						// string (caminho da imagem)
 	public $variablename;				// string
 	public $title;						// string
 	public $position;					// array
 	public $balloncontent;				// conteudo do balão de descrição
 	public $exibeballon;				// boolean [default: false]


 	public function __construct(){
 		if(!isset($this->icon)){$this->icon='\'\'';};if(!isset($this->title)){$this->title='\'\'';};if(!isset($this->variablename)){$this->variablename='descri';};if(!isset($this->balloncontent)){$this->balloncontent='<div><h1>hellou!</h1></div>';};

 	}
 	public function render(){
 		echo 'var marker'.$this->variablename.' = new google.maps.Marker({position: {lat: '.$this->position["lat"].', lng: '.$this->position["lng"].'}, map: '.$this->mapa.', title: \''.$this->title.'\',icon: \''.$this->icon.'\'});';
		echo 'var '.$this->variablename.' = \''.$this->balloncontent.'\';';
		if(isset($this->exibeballon)){
			echo 'var infow_'.$this->variablename.' = new google.maps.InfoWindow({content: '.$this->variablename.'}); marker'.$this->variablename.'.addListener(\'click\', function(){infow_'.$this->variablename.'.open('.$this->mapa.', marker'.$this->variablename.');});';	
   		};
 	}

 }
?>