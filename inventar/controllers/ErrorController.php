<?php
class ErrorController extends Controller
{
    public function process($parameters) {
        header("HTTP/1.0 404 Not Found");
        $this->header['title'] = 'Chyba 404';
        $this->view = 'error';
    }
}