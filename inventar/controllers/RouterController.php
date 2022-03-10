<?php
class RouterController extends Controller
{
    public $controller;

	private function parseURL($url) {
        $parsed_URL = parse_url($url);
        $parsed_URL["path"] = ltrim($parsed_URL["path"], "/");
        $parsed_URL["path"] = trim($parsed_URL["path"]);

        $arr_path = explode("/", $parsed_URL["path"]);
        return $arr_path;
    }
	
	
    public function process($parameters) {
        $parsed_URL = $this->parseURL($parameters[0]);
		
        if (empty($parsed_URL[0])) {
            $this->redirect('prihlaseni');
        }
        
		
		$controller_class = array_shift($parsed_URL) . 'Controller';
		
        if (file_exists('controllers/' . $controller_class . '.php')) {
            $this->controller =  new $controller_class;
        } else {
            $this->redirect('error');
        }
        
        $this->controller->process($parsed_URL);

        $this->data['title'] = $this->controller->header['title'];
        $this->data['messages'] = $this->showMessage();
        $this->data['warnings'] = $this->showWarning();
		

        $this->view = 'template';
		
    }



}