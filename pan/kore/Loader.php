<?php

namespace pan;


class Loader {


    /**
     * Cargar una entidad (Entity)
     * @param  string  $_entity   Ruta de la entidad a cargar, de la forma Modulo/Entidad
     * @param  boolean $_instance [description]
     * @return object             Entidad cargada
     */
    public static function entity($_entity,$_instance=true){
        try{
            $ext = '.php';
            if(!preg_match('/\.php/i',$_entity)){
                $ext = '.php';
            }

            $entity_path = explode("/",$_entity);
            $path_entity = '';
            for($i = 0; $i < count($entity_path); $i++){
                if($i == 0){
                    $path_entity = $entity_path[$i]. DIRECTORY_SEPARATOR . 'entities' . DIRECTORY_SEPARATOR;
                }else{
                    $path_entity .= $entity_path[$i];
                }
            }

            $pathModel = 'app/' . $path_entity . $ext;
            global $modelo;
            $modelo = $_entity;
            if (is_readable($pathModel) and is_file($pathModel)) {
                require_once $pathModel;
                //$entity = explode('/',$_entity);
                $entity = end($entity_path);
                $modelo = new $entity();
                return $modelo;
                
            } else {
                panError::_showErrorAndDie('Entity <strong>'.$_entity.'</strong> </strong> no encontrado');
            }
        }catch(Exception $e){
            throw new Exception('Error de entidad : '.$_entity);
        }
        
    }


    /**
     * Cargar una libreria
     * @param  string  $_library  Ruta de la libreria, en la forma Modulo/Libreria
     * @param  boolean $_instance [description]
     * @return object             Libreria cargada
     */
    public static function library($_library,$_instance=true){
        try{
            $ext = '.php';
            if(!preg_match('/\.php/i',$_library)){
                $ext = '.php';
            }

            $library_path = explode("/",$_library);
            $path_library = '';
            for($i = 0; $i < count($library_path); $i++){
                if($i == 0){
                    $path_library = $library_path[$i]. DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR;
                }else{
                    $path_library .= $library_path[$i];
                }
            }

            $pathModel = 'app/' . $path_library . $ext;
            global $modelo;
            $modelo = $_library;
            if (is_readable($pathModel) and is_file($pathModel)) {
                require_once $pathModel;
                //$entity = explode('/',$_entity);
                $library = end($library_path);
                $modelo = new $library();
                return $modelo;
                
            } else {
                panError::_showErrorAndDie('Librería <strong>'.$_library.'</strong> </strong> no encontrado');
            }
        }catch(Exception $e){
            throw new Exception('Error de librería : '.$_library);
        }
        
    }

}