<?php
@session_start(); 

 class ControllerFront extends Controller
 {
	
	public function __construct()
	{
		parent::__construct('publico');
	}
 
	private function haySesion(){
	 	return ((isset($_SESSION['USUARIO']) && (isset($_SESSION['USUARIO']['rol'])) && (isset($_SESSION['USUARIO']['id']))));
	}
 
	public function inicio()
     {
		
		if($this->haySesion()){
			echo $this->twig->render('index.twig.html', array('log' => '1'));
			}
		else{
			echo $this->twig->render('index.twig.html', array());}
		
     }
	 
	 public function inicioErr()
     {
		echo $this->twig->render('index.twig.html', array('mensaje' => 'Usuario o contraseña incorrectos.'));
     }
	 
	 
	public function contacto()
    {
		// array( clave_api		clave_secreta	credencial_oauth	secreto_oauth)
		$params = $this->us->link();
		try {
			$oauth = new OAuth($params['clave_api'], $params['clave_secreta']);
			$oauth->setToken($params['credencial_oauth'], $params['secreto_oauth']);
			$params = array();
			$headers = array();
			$method = OAUTH_HTTP_METHOD_GET;
			$url = "http://api.linkedin.com/v1/people/~?format=json";
			$oauth->fetch($url, $params, $method, $headers);
			$link = $oauth->getLastResponse();

			$json = json_decode($link);
			
			$params = array('firstName' => $json->firstName,
							'lastName' => $json->lastName,
							'headline' => $json->headline,
							'url' => $json->siteStandardProfileRequest->url
						);
		} catch (Exception $e){
			$error = "No se pudo conectar a la base de LinkedIn.";
		}
		
		if($this->haySesion()){
			echo $this->twig->render('contacto.twig.html', array('log' => '1', 'params' => $params, 'mensaje'=>$error));
			}
		else{
			echo $this->twig->render('contacto.twig.html', array('params' => $params, 'mensaje'=>$error));
		}
	}

	 
	public function listarDonantes()
    {	 
        $params = array('donantes' => $this->mD->listar());
		if($this->haySesion()){
			echo $this->twig->render('listadoDonantes.html', array('donantes' => $params['donantes'], 'log' => '1'));}
		else{
		
			echo $this->twig->render('listadoDonantes.html', array('donantes' => $params['donantes']));}
    }

    public function listarEntidades()
    {
        $params = array('entidades' => $this->mE->listar());
		if($this->haySesion()){
		echo $this->twig->render('listadoEntidades.html', array('entidades' => $params['entidades'], 'log' => '1'));}
		else {
		echo $this->twig->render('listadoEntidades.html', array('entidades' => $params['entidades']));}
    }

    public function quienesSomos()
    {
	
		if($this->haySesion()){
			echo $this->twig->render('quienesSomos.twig.html', array('log' => '1'));}
		else{
         echo $this->twig->render('quienesSomos.twig.html', array());}
     }

 }
 
?>