<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ArticlesTable extends Table{
	public function initialize(array $config){
		$this->addBehavior('Timestamp');
		$this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
        ]);
	}

	public function validationDefault(Validator $validator) //Validaciones al ejecutarse save() en las acciones add y edit del controlador
    {
        $validator->notEmpty('title')->notEmpty('body'); //title y body no están vacíos
        return $validator;
    }

    public function isOwnedBy($articleId, $userId)
    {
        return $this->exists(['id' => $articleId, 'user_id' => $userId]);
    }
}