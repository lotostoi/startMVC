<?php 
namespace controller;



abstract class Controller {

abstract function render();


    public function viewTamplate ($fileName, $arrData) {
    try {
            $loader = new \Twig\Loader\FilesystemLoader("./views");
           
            $twig = new \Twig\Environment($loader);

            $template = $twig->load($fileName);
          
            $cont =  $template->render($arrData);
            return $cont;
        } catch (Exception $e) {
            die('ERROR - ' . $e->getMessage());
        }
    }


}

?>