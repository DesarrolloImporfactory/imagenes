<?php

class HomeModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function subir($imagen)
    {
        $target_dir = "public/img/repositorio/";

        $target_file = $target_dir . basename($imagen["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($imagen["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $response['status'] = 500;
            $response['title'] = 'Error';
            $response['message'] = 'El archivo no es una imagen';
            $uploadOk = 0;
        }
        if ($imagen["size"] > 500000) {
            $response['status'] = 500;
            $response['title'] = 'Error';
            $response['message'] = 'El archivo es muy grande';
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $response['status'] = 500;
            $response['title'] = 'Error';
            $response['message'] = 'Solo se permiten archivos JPG, JPEG, PNG';
            $uploadOk = 0;
        } else {
            if (move_uploaded_file($imagen["tmp_name"], $target_file)) {
                $response['status'] = 200;
                $response['title'] = 'Peticion exitosa';
                $response['message'] = 'Imagen subida correctamente';
                $response['data'] = $target_file;

                /* $sql = "UPDATE perfil SET logo_url  = ? WHERE id_plataforma = ?";
                $data = [$target_file,  $plataforma];
                $editar_imagen = $this->update($sql, $data);
                if ($editar_imagen == 1) {
                    $response['status'] = 200;
                    $response['title'] = 'Peticion exitosa';
                    $response['message'] = 'Imagen subida correctamente';
                } else {
                    $response['status'] = 500;
                    $response['title'] = 'Error';
                    $response['message'] = 'Error al subir la imagen';
                } */
            } else {
                $response['status'] = 500;
                $response['title'] = 'Error';
                $response['message'] = 'Error al subir la imagen';
            }
        }
        return $response;
    }

    public function landing($landing, $id_producto)
    {
        $target_dir = "public/landing/repositorio/";

        $target_file = $target_dir . basename($landing["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Verificar si el archivo es HTML
        if ($fileType != "html") {
            $response['status'] = 500;
            $response['title'] = 'Error';
            $response['message'] = 'Solo se permiten archivos HTML';
            $uploadOk = 0;
        }

        // Verificar el tama帽o del archivo
        if ($landing["size"] > 500000) {
            $response['status'] = 500;
            $response['title'] = 'Error';
            $response['message'] = 'El archivo es muy grande';
            $uploadOk = 0;
        }

        // Si todo est谩 bien, intenta subir el archivo
        if ($uploadOk == 1) {
            if (move_uploaded_file($landing["tmp_name"], $target_file)) {
                $response['status'] = 200;
                $response['title'] = 'Petici贸n exitosa';
                $response['message'] = 'Archivo subido correctamente';
                $response['data'] = $target_file;

                $sql = "INSERT INTO landing (id_producto, contenido) VALUES (?, ?)";
                $data = [$id_producto, $target_file];
                $insertar_landing = $this->insert($sql, $data);
                
                $sql = "UPDATE `productos` SET `landing`=? WHERE id_producto=?";
         //echo $sql;
        $data_update = [$target_file, $id_producto];
         //print_r($data_update);
        $editar_producto = $this->update($sql, $data_update);
        
            } else {
                $response['status'] = 500;
                $response['title'] = 'Error';
                $response['message'] = 'Error al subir el archivo';
            }
        }

        // Devuelve la respuesta
        return $response;
    }
    
    public function landingTienda($landing, $id_producto)
    {
        $target_dir = "public/landing/repositorio/";

        $target_file = $target_dir . basename($landing["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Verificar si el archivo es HTML
        if ($fileType != "html") {
            $response['status'] = 500;
            $response['title'] = 'Error';
            $response['message'] = 'Solo se permiten archivos HTML';
            $uploadOk = 0;
        }

        // Verificar el tama帽o del archivo
        if ($landing["size"] > 500000) {
            $response['status'] = 500;
            $response['title'] = 'Error';
            $response['message'] = 'El archivo es muy grande';
            $uploadOk = 0;
        }

        // Si todo est谩 bien, intenta subir el archivo
        if ($uploadOk == 1) {
            if (move_uploaded_file($landing["tmp_name"], $target_file)) {
                $response['status'] = 200;
                $response['title'] = 'Petici贸n exitosa';
                $response['message'] = 'Archivo subido correctamente';
                $response['data'] = $target_file;

                              
                $sql = "UPDATE `productos_tienda` SET `landing_tienda`=?, landing_propia=? WHERE id_producto_tienda=?";
         //echo $sql;
        $data_update = [$target_file,1, $id_producto];
         //print_r($data_update);
        $editar_producto = $this->update($sql, $data_update);
        
            } else {
                $response['status'] = 500;
                $response['title'] = 'Error';
                $response['message'] = 'Error al subir el archivo';
            }
        }

        // Devuelve la respuesta
        return $response;
    }

    public function editarLanding($id_producto, $html)
    {
        $sql = "SELECT * FROM landing WHERE id_producto = $id_producto";

        $landing = $this->select($sql);

        $contenido = $landing[0]['contenido'];
        //hacer un put de contenido
        $file = fopen($contenido, "w");
        fwrite($file, $html);
        fclose($file);

        $response['status'] = 200;
        $response['title'] = 'Petici贸n exitosa';
        $response['message'] = 'Landing editado correctamente';

        return $response;
    }

    
    public function editarLandingTienda($id_producto, $html)
    {
        $sql = "SELECT * FROM productos_tienda WHERE id_producto_tienda = $id";

        $landing = $this->select($sql);

        $contenido = $landing[0]['landing_tienda'];
        //hacer un put de contenido
        $file = fopen($contenido, "w");
        fwrite($file, $html);
        fclose($file);

        $response['status'] = 200;
        $response['title'] = 'Petici贸n exitosa';
        $response['message'] = 'Landing actuialzaido correctamente';

        return $response;
    }
    
    public function obtenerLanding($id)
    {
        $sql = "SELECT * FROM landing WHERE id_producto = $id";
        $landing = $this->select($sql);
        $landing = $landing[0]['contenido'];

        $contenido = file_get_contents($landing);
        $contenido = htmlspecialchars($contenido);
        return $contenido;
    }
    
     public function obtenerLandingTienda($id)
    {
        $sql = "SELECT * FROM productos_tienda WHERE id_producto_tienda = $id";
        $landing = $this->select($sql);
        $landing = $landing[0]['landing_tienda'];

        $contenido = file_get_contents($landing);
        $contenido = htmlspecialchars($contenido);
        return $contenido;
    }
}
