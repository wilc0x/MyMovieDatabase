<?php
namespace Movie\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class MovieTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getMovie($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveMovie(Movie $movie)
    {
        $data = [
            'title' => $movie->title,
            'genre'  => $movie->genre,
			'actors' => $movie->actors,
			'rating' => $movie->rating,
        ];

        $id = (int) $movie->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getMovie($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update movie with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteMovie($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}