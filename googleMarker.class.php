<?php
class googleMarker {
  /*
  Data Criação: 18/01/2018
  */
  public $userKey;
  public $latitude = "-14.235004";                                  // ponto no mapa: latitude
  public $longitude = "-51.92528";                                  // ponto no mapa: longitude
  public $setMap = "screen";                                        // mapa que será colocado os pontos
  public $title = "Brasil!";                                        // titulo [alt] do ponto
  public $icon = '/public/images/syspng/chicken.png';               // url da imagem a ser utilizada
  public function __construct(){

  }
  public function render(){
  $this->somacontent = 'var marker = new google.maps.Marker({
          position: {lat: '.$this->latitude.', lng: '.$this->longitude.'},
          title: \'Brasil!\',
          map: '.$this->setMap.',
          icon: "'.$this->icon.'"
        });';
  return $this->somacontent;
  }
  public function mountAdress($adress = []){
    $urlStar = 'https://maps.googleapis.com/maps/api/geocode/json?address=';
    $glue = implode("+", $adress);
    $result = str_replace(" ", "+", $glue);
    $endUrl = $urlStar.$result.'&key='.$this->userKey;
    return $endUrl;
  }
  public function returnCords ($endereco){
      $url = curl_init();
      curl_setopt($url, CURLOPT_URL, $endereco);
      curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
      $retorno = json_decode(curl_exec($url), true);

      $lat = $retorno["results"]["0"]["geometry"]["location"]["lat"];
      $lng = $retorno["results"]["0"]["geometry"]["location"]["lng"];

      $cordenadas = [];
      $cordenadas["lat"] = $lat;
      $cordenadas["lng"] = $lng;
      return $cordenadas;
      curl_close($url);
    }
}
?>