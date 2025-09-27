<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ServiceController extends AbstractController
{
    #[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }
      #[Route('/goToindex', name: 'go')]
   public function goToIndex(): Response
    {
        return $this->redirectToRoute('app_service'
        );
    }
        #[Route('/showService/{name}', name: 'showService')]
  public function showService($name): Response
    {
        return  $this->render  ('service/showService.html.twig', [
            'name' => $name,
        ]);
    }
  


}
