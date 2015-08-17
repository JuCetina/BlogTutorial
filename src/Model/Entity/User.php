<?php

namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

class User extends Entity
{

    //Permite a todos los campos ser asignados en masa excepto el campo PK 'id'
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    

    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password); //Hace un hash a la contraseña del usuario
    }

    
}