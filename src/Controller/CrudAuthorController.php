<?php

namespace App\Controller;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Author;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Attribute\Route;
#[Route('/crud/author')]
class CrudAuthorController extends AbstractController
{
    #[Route('/list', name: 'app_crud_author')]
    public function list(AuthorRepository $repository): Response
    {
        $list=$repository->findAll();
        return $this->render('crud_author/list.html.twig',['list'=>$list]);
    }

    //method to search an author by name
    #[Route("/search/{name}",name:'app_crud_search')]
    public function searchByName(AuthorRepository $repository,Request $request):Response
    {
        $name=$request->get('name');
        $list=$repository->findByName($name);
        return $this->render('crud_author/list.html.twig',['list'=>$list]);



    }
    //method to insert a new author
    #[Route('/new', name:'app_new_author')]
    public function newAuthor(ManagerRegistry $doctrine):Response
    {
        $author=new Author();
        $author->setName('Ahmed');
        $author->setEmail('ahmed@gmail.com');
        $author->setAddress('Tunis');
        $author->setNbrBooks(4);
        //persist the object in the doctrine
        $em=$doctrine->getManager();
        $em->persist($author);
        $em->flush();
        return $this->redirectToroute('app_crud_author');

    }
    //method to delete an author
    #[Route("/delete/{id}", name:"app_delete_author")]
    public function deleteAuthor(Author $author, ManagerRegistry $doctrine):Response {
        $em=$doctrine->getManager();
        $em->remove($author);
        $em->flush();
        return $this->redirectToroute("app_crud_author");
    }


    //method to update
    #[Route("/update/{id}", name:"app_update_author")]
    public function updateAuthor(Author $author, ManagerRegistry $doctrine): Response {
        $author->setName('Ahmed');
        $author->setEmail('ahmed@gmail.com');
        $author->setAddress('Nabeul');
        $author->setNbrBooks(4);
        $em=$doctrine->getManager();
        $em->flush();
        return $this->redirectToroute("app_crud_author");



    }
}
