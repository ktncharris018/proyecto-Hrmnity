<?php 
namespace App\Libraries;

class FileHandler {

    public function upload($tipo, $categoria, $file, $nombreFile) {
        if ($file->isValid() && !$file->hasMoved()) {
            $path = FCPATH . "uploads/$tipo/$categoria/";
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }

            // Eliminar el archivo anterior si existe
            $this->deleteFileIfExists($tipo, $categoria, $nombreFile);

            // Mover el nuevo archivo
            $file->move($path, $nombreFile);
            return true;
        }
        return false;
    }

    public function deleteFileIfExists($tipo, $categoria, $nombreFile) {
        $filePath = $this->getFilePath($tipo, $categoria, $nombreFile);
        if (file_exists($filePath)) {
            unlink($filePath); // Elimina el archivo
        }
    }

    public function getFilePath($tipo, $categoria, $nombreFile) {
        return FCPATH . "uploads/$tipo/$categoria/$nombreFile";
    }
}

