<?php


namespace pan;


class Migas {


	public static function getHelp($option="me"){

		$msg_help = "Ayuda rapida para Migas::PANDEMOLDE\n\n";

		$msg_help .= "php migas [option::action]\n\n";

		/** app */
		if($option == "me" || $option == "app"){
			$msg_help .= "- app::create\t\t\t\t\t\t\tCrear estructura de la aplicacion\n";	
		}
		
		/** module */
		if($option == "me" || $option == "module"){
			$msg_help .= "- module::MODULE_NAME\t\t\t\t\t\tCrear modulo con el nombre pasado en MODULE_NAME\n";	
		}

		/** controller */
		if($option == "me" || $option == "controller"){
			$msg_help .= "- controller::MODULE_NAME/CONTROLLER_NAME\t\t\tCrear controlador CONTROLLER_NAME dentro del modulo MODULE_NAME\n";	
		}

		/** controller */
		if($option == "me" || $option == "entity"){
			$msg_help .= "- entity::MODULE_NAME/ENTITY_NAME\t\t\t\tCrear entidad ENTITY_NAME dentro del modulo MODULE_NAME\n";	
		}

		return $msg_help;

	}


}