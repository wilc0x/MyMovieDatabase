<?php
namespace Movie\Form;

use Zend\Form\Form;

class MovieForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('movie');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'title',
            'type' => 'text',
            'options' => [
                'label' => 'Title',
            ],
        ]);
        $this->add([
            'name' => 'genre',
            'type' => 'text',
            'options' => [
                'label' => 'Genre',
            ],
        ]);
		$this->add([
			'name' => 'actors',
			'type' => 'text',
			'options' => [
				'label' => 'Actors',
			],
        ]);
		$this->add([
			'name' => 'rating',
			'type' => 'text',
			'options' => [
				'label' => 'Rating (1-5 rounded down to the nearest .5)',
			],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}