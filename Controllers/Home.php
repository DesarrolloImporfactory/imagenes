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
        $id_producto = $_POST['id_producto'];
        $response = $this->model->landing($landing, $id_producto);
        echo json_encode($response);
    }

    public function editarLanding()
    {
        $id_producto = $_POST['id_producto'];
        $html = $_POST['html'];
        $response = $this->model->editarLanding($id_producto, $html);
        echo json_encode($response);
    }

    public function obtenerLanding()
    {
        $id_producto = $_POST['id_producto'];
        $response = $this->model->obtenerLanding($id_producto);
        echo json_encode(["status" => 200, "data" => $response]);
    }
    
      public function obtenerLandingTienda()
    {
        $id_producto_tienda = $_POST['id_producto_tienda'];
        $response = $this->model->obtenerLandingTienda($id_producto_tinda);
        echo json_encode(["status" => 200, "data" => $response]);
    }
}
