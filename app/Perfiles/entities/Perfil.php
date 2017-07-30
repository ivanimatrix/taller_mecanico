<?php

class Perfil extends \pan\Entity{


    protected $table = 'perfil';

    protected $primary_key = 'codigo_perfil';

    const ADMINISTRADOR = 1;
    const MECANICO = 2;
    const CLIENTE = 3;

 }