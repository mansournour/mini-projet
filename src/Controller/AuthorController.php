<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Attribute\Route;

final class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/get', name: 'get_author')]
    public function getAll(AuthorRepository $authRepo): Response
    {
        $auteurs = $authRepo->findAll();

        return $this->render('author/index.html.twig', [
            'auteurs' => $auteurs,
        ]);
    }

    #[Route('/add', name: 'add_author')]
    public function addAuth(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();

        // Premier auteur
        $auth1 = new Author();
        $auth1->setUsername('author1');
        $auth1->setEmail('author1@gmail.com');
        $em->persist($auth1);

        // Deuxième auteur
        $auth2 = new Author();
        $auth2->setUsername('author2');
        $auth2->setEmail('author2@gmail.com');
        $em->persist($auth2);

        // Sauvegarde en base
        $em->flush();

        return $this->redirectToRoute('get_author'); // redirection vers la liste
    }

    #[Route('/delete/{id}', name: 'app_delete')]
    public function deleteAuthor(ManagerRegistry $doctrine, AuthorRepository $authRepo, int $id): Response
    {
        $em = $doctrine->getManager();
        $author = $authRepo->find($id);

        if (!$author) {
            return new Response("Auteur avec ID $id introuvable ");
        }

        $em->remove($author);
        $em->flush();

        return $this->redirectToRoute('get_author'); // redirection vers la liste
    }

    // ✅ Nouvelle méthode pour modifier un auteur
    #[Route('/update/{id}', name: 'update_author')]
    public function updateAuthor(ManagerRegistry $doctrine, AuthorRepository $authRepo, int $id): Response
    {
        $em = $doctrine->getManager();
        $author = $authRepo->find($id);

        if (!$author) {
            return new Response("Auteur avec ID $id introuvable ");
        }

        // Exemple : modifier le nom et l'email
        $author->setUsername('Auteur Modifié');
        $author->setEmail('modifie@example.com');

        $em->flush();

        return $this->redirectToRoute('get_author'); // redirection vers la liste
    }

    #[Route('/showAuthor/{username}', name: 'show_author')]
    public function showAuthor(string $username): Response
    {
        return $this->render('author/show.html.twig', [
            'username' => $username,
        ]);
    }

    #[Route('/listAuthor', name :'listAuthor')]
    public function listAuthor(): Response 
    {
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-hugo.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/willliam.jpg','username' => 'William Shakespeare', 'email' => 'william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/TahaHussein.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
        );

        return $this->render('author/list.html.twig',[
            'authors'=>$authors ,
        ]);
    }

    #[Route('/authorDetails/{id}', name: 'authorDetails')]
    public function authorDetails($id): Response 
    {
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-hugo.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/willliam.jpg','username' => 'William Shakespeare', 'email' => 'william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/TahaHussein.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
        );

        $author = null;
        foreach ($authors as $a) {
            if ($a['id'] == $id) {
                $author = $a;
                break;
            }
        }

        return $this->render('author/showAuthor.html.twig', [
            'author' => $author,
        ]);
    }
}
