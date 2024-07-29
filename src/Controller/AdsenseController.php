<?php

namespace App\Controller;

use App\Entity\Adsense;
use App\Repository\AdsenseRepository;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/manager/adsenses', name: 'adsenses_')]
class AdsenseController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(AdsenseRepository $adsRepository): Response
    {
        $adsenses = $adsRepository->findAll();

        return $this->render('adsense/index.html.twig', compact('adsenses'));
    }

    #[Route('/{id}', name: 'edit')]
    public function getid(AdsenseRepository $adsRepository, int $id): Response
    {
        //Mostar a adsense completa por id
        $ads = $adsRepository->findOneById($id);

        if(!$ads) throw $this->createNotFoundException('Anúncio não encontrado');

        return $this->render('adsense/edit.html.twig', compact('ads'));
    }

    #[Route('/teste', name: 'teste')]
    public function teste(EntityManagerInterface $manager, AdsenseRepository $repo): Response
    {
        //Inserção em Doctrine
        $tmz = new DateTimeZone('America/Sao_Paulo');

        $ads = new Adsense();
        $ads->setTitle('Titulo Teste');
        $ads->setDescription('Descrição do aúncio');
        $ads->setBady('Conteúdo do aúncio');
        $ads->setSlug('titulo-teste');
        $ads->setCreatedAt(new \DateTimeImmutable('now', $tmz));
        $ads->setUpdateAt(new \DateTimeImmutable('now', $tmz));

        $manager->persist($ads);
        $manager->flush();



        //Atualização do dados
        //$ads = $repo->findOneById(1);

        //$ads->setTitle('Titulo Teste Editado');
        //$ads->setDescription('Descrição do aúncio editado');
        
        //$manager->persist($ads);
        //$manager->flush();

        //Removendo os dados
        //$ads = $repo->findOneById(1);
        
        //$manager->remove($ads);
        //$manager->flush();

        return new Response('Teste...');
}
}