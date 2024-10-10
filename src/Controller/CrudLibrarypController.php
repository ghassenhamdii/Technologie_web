<?php

namespace App\Controller;

use App\Entity\Library;
use App\Form\LibraryType;  // Importation du formulaire
use App\Repository\LibraryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;

#[Route('/crud/Libraryp')]
class CrudLibrarypController extends AbstractController
{
    // Afficher la liste des bibliothèques
    #[Route('/listl', name: 'app_crud_Libraryp')]
    public function listl(LibraryRepository $repository): Response
    {
        $listl = $repository->findAll(); // Récupérer toutes les bibliothèques
        return $this->render('crud_libraryp/listl.html.twig', ['listl' => $listl]);
    }

    // Rechercher une bibliothèque par nom
    #[Route("/search/{name}", name: 'app_crud_search')]
    public function searchByName(LibraryRepository $repository, Request $request): Response
    {
        $name = $request->get('name');
        $libraries = $repository->findByName($name);
        return $this->render('crud_libraryp/listl.html.twig', ['listl' => $libraries]);
    }

    // Ajouter une nouvelle bibliothèque
    #[Route('/new', name: 'app_new_Libraryp')]
    public function newLibraryp(Request $request, ManagerRegistry $doctrine): Response
    {
        $library = new Library();
        return $this->handleLibraryForm($library, $request, $doctrine);
    }

    // Modifier une bibliothèque
    #[Route('/edit/{id}', name: 'app_edit_Libraryp')]
    public function editLibraryp(int $id, LibraryRepository $repository, Request $request, ManagerRegistry $doctrine): Response
    {
        $library = $repository->find($id);
        if (!$library) {
            throw $this->createNotFoundException('Bibliothèque non trouvée');
        }
        return $this->handleLibraryForm($library, $request, $doctrine);
    }

    // Méthode générale pour gérer le formulaire
    private function handleLibraryForm(Library $library, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(LibraryType::class, $library);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($library);
            $em->flush();

            return $this->redirectToRoute('app_crud_Libraryp');
        }

        return $this->render('crud_libraryp/library_form.html.twig', [
            'form' => $form->createView(),
            'library' => $library,
        ]);
    }

    // Supprimer une bibliothèque
    #[Route('/delete/{id}', name: 'app_crud_delete')]
    public function deleteLibraryp(Library $library, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $em->remove($library);
        $em->flush();

        return $this->redirectToRoute('app_crud_Libraryp');
    }
}
