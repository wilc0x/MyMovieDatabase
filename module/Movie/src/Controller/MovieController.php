<?php
namespace Movie\Controller;

use Movie\Model\MovieTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Client;
use Movie\Form\MovieForm;
use Movie\Model\Movie;


class MovieController extends AbstractActionController
{
	private $table;
	
	public function __construct(MovieTable $table)
    {
        $this->table = $table;
    }
	
    public function indexAction()
    {
		$movies = json_decode(json_encode($this->table->fetchAll()->toArray()), FALSE);
		
		$movies = $this->getRatings($movies);
		
		return new ViewModel([
			'movies' => $movies,
		]);
    }

    public function addAction()
    {
		$form = new MovieForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $movie = new Movie();
        $form->setInputFilter($movie->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $movie->exchangeArray($form->getData());
        $this->table->saveMovie($movie);
        return $this->redirect()->toRoute('movie');
    }

    public function editAction()
    {
		$id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('movie', ['action' => 'add']);
        }

        try {
            $movie = $this->table->getMovie($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('movie', ['action' => 'index']);
        }

        $form = new MovieForm();
        $form->bind($movie);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($movie->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveMovie($movie);

        return $this->redirect()->toRoute('movie', ['action' => 'index']);
    }

    public function deleteAction()
    {
		 $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('movie');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteMovie($id);
            }

            return $this->redirect()->toRoute('movie');
        }

        return [
            'id'    => $id,
            'movie' => $this->table->getMovie($id),
        ];
    }
	
	// fetches ratings from OMDB for movies without ratings
	private function getRatings($movies)
	{
		$ratedMovies = [];
		$client = new Client('http://www.omdbapi.com');
		$MovieModel = new Movie();
	
		foreach ($movies as $movie) {
			if ($movie->rating === null) {

				$client->setParameterGet([
					'apikey'  => 'b71e0a07',
					't' => $movie->title,
				]);

				$response = $client->send();
				
				$imdbRating = json_decode($response->getBody())->imdbRating;
				
				$movie->rating = $MovieModel->filterRating($imdbRating/2);
			}
			
			array_push($ratedMovies, $movie);
		}
		
		return $ratedMovies;
	}
}