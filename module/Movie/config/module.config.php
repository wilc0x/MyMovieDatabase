<?php
namespace Movie;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'movie' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/movie[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\MovieController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
	
    'view_manager' => [
        'template_path_stack' => [
            'movie' => __DIR__ . '/../view',
        ],
    ],
];