<?php

use FontLib\EOT\Header;

session_start();
class Home extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    ///Vistas
    public function index()
    {
        $this->views->render($this, "index");
    }

    public function subir()
    {
        $imagen = $_FILES['file'];
        $response = $this->model->subir($imagen);
        echo $response["data"];
    }

    public function landing()
    {
        $landing = $_FILES['file'];
        $response = $this->model->landing($landing);
        echo $response["data"];
    }
    ///Funciones
}
