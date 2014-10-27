<?php

 class ControllerFront extends Controller
 {
	
	public function __construct()
	{
		parent::__construct('publico');
	}
 
	public function inicio()
     {
		echo $this->twig->render('index.twig.html', array());
     }
	 
	public function contacto()
    {
		echo $this->twig->render('contacto.twig.html', array());
    }
    	 
	public function mensaje()
    {
		echo $this->twig->render('mensajeFront.twig.html', array('mensaje' => $_GET));
    }
	 
	public function listarDonantes()
    {	 
        $params = array('donantes' => $this->mD->listar());
		echo $this->twig->render('listadoDonantes.html', array('donantes' => $params['donantes']));
    }

    public function listarEntidades()
    {
        $params = array('entidades' => $this->mE->listar());
		echo $this->twig->render('listadoEntidades.html', array('entidades' => $params['entidades']));
    }

    public function quienesSomos()
    {
         echo $this->twig->render('quienesSomos.twig.html', array());
     }

 }
 
?>