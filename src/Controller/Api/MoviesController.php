<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;

class MoviesController extends AbstractController
{
    #[Route('/api/movies')]
    public function list(Connection $db): Response
    {
        $rows = $db->createQueryBuilder()
            ->select("m.*")
            ->from("movies", "m")
            ->orderBy("m.release_date", "DESC")
            ->setMaxResults(50)
            ->executeQuery()
            ->fetchAllAssociative();

        return $this->json([
            "movies" => $rows
        ]);
    }
    #[Route('/api/movies_by_rating')]
    public function listRating(Connection $db): Response
    {
        $rows = $db->createQueryBuilder()
            ->select("m.*")
            ->from("movies", "m")
            ->orderBy("m.rating", "DESC")
            ->setMaxResults(50)
            ->executeQuery()
            ->fetchAllAssociative();

        return $this->json([
            "movies" => $rows
        ]);
    }

    #[Route('/api/genere_movies')]
    public function listGeneri(Connection $db): Response
    {
        $rows = $db->createQueryBuilder()
            ->select("g.*")
            ->from("genres", "g")
            ->setMaxResults(50)
            ->executeQuery()
            ->fetchAllAssociative();

        return $this->json([
            "generi" => $rows
        ]);
    }
    #[Route('/api/movies_by_genre/{g}')]
    public function moviesByGenre(Connection $db, string $g ): Response
    {
        $rows = $db->createQueryBuilder()
            ->select("movies.*")
            ->from("movies, movies_genres")
            ->where("movies_genres.genre_id = ? AND movies.id = movies_genres.movie_id")
            ->setParameter(0,$g)
            ->setMaxResults(50)
            ->executeQuery()
            ->fetchAllAssociative();

        return $this->json([
            "movies" => $rows
        ]);
    }
}
