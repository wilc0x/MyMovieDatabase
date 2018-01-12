<?php
namespace Movie\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;
use Zend\Validator\Regex;
use Zend\Validator\LessThan;
use Zend\Validator\GreaterThan;

class Movie
{
    public $id;
    public $title;
    public $genre;
	public $actors;
	public $rating;
	
	private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->title = !empty($data['title']) ? $data['title'] : null;
        $this->genre  = !empty($data['genre']) ? $data['genre'] : null;
		$this->actors  = !empty($data['actors']) ? $data['actors'] : null;
		$this->rating  = !empty($data['rating']) ? $data['rating'] : null;
    }
	
	 public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'title' => $this->title,
            'genre'  => $this->genre,
			'actors' => $this->actors,
			'rating' => $this->rating,
        ];
    }
	
	public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'title',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'genre',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);
		
		 $inputFilter->add([
            'name' => 'actors',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 200,
                    ],
                ],
            ],
        ]);
		
		$inputFilter->add([
            'name' => 'rating',
            'required' => false,
            'filters' => [
				[
					'name' => 'Callback',
					'options' => [
						'callback' => [$this, 'filterRating'],
					]
				]
            ],
            'validators' => [
				[
					'name' => Regex::class,
					'options' => [
						'pattern' => '/[1-9.]/',
					],
				],
				[
                    'name' => LessThan::class,
                    'options' => [
                        'inclusive' => true,
                        'max' => 5,
                    ],
                ],
				[
                    'name' => GreaterThan::class,
                    'options' => [
                        'inclusive' => true,
                        'min' => 1,
                    ],
                ],
            ],
        ]);
		
        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
	
	// rounds value down to nearest .5
	public function filterRating($value)
	{	
		if (!is_numeric($value))
		{
			return $value;
		}
		
		$num = floor($value * 2) / 2;
		$num = number_format($num, 1);
		return $num;
	}
}