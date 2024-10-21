<?php

namespace App\Controller\Api;

use App\Entity\HistoryContent\HistoryContent;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Service\Attribute\Required;

#[Route('/api')]
class GetHistoryContentByType extends AbstractController
{
    #[Required]
    public EntityManagerInterface $entityManager;

    #[Required]
    public SerializerInterface $serializer;

    #[Route('/history/{id}', name: 'rwar')]
    public function invoke(string $id): Response
    {
        $content = new ArrayCollection($this->entityManager->getRepository(HistoryContent::class)->findAll());

        $typedContent = $content->filter(function (HistoryContent $content) use ($id) {
            return $content->getType()->getApiResource() === $id;
        });

        $response = $this->serializer->serialize($typedContent, 'json');
        return new Response($response, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}