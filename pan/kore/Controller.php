<?php
namespace pan;

abstract class Controller {
	

	protected $view;
    protected $request;
    protected $session;
    
	public function __construct(){
        if(App::getSessionApp()){
            $this->session =  new panSession();
        }
        $this->request = new Request();

        $this->view = new View();

        if(App::getTemplate() != ""){
            $template = App::getTemplate();
            $template = new $template();
            $this->view = $template->getTemplate();
        }

        $this->load = new Loader();

	}
}