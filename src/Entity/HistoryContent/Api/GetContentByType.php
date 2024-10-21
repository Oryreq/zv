<?php

namespace App\Entity\HistoryContent\Api;

use App\Entity\HistoryContent\HistoryContent;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Service\Attribute\Required;

#[AsController]
class GetContentByType extends AbstractController
{
    #[Required]
    public LoggerInterface $logger;



    #[Route('api/history/type', name: 'rwar', methods: ['GET'])]
    public function test(): Response
    {
        $this->logger->info('----------------------------------------------------------------------------------------');
        #$this->logger->info($id);
        #$this->historyContentHandler->handle($historyContent);
        $this->logger->info('----------------------------------------------------------------------------------------');
        return $this->redirect('/');
    }


    ##[Route('/history/type/{id}', name: 'test')]
    public function test2($test)
    {
        $this->logger->info('----------------------------------------------------------------------------------------');
        $this->logger->info($test);
        #$this->historyContentHandler->handle($historyContent);
        $this->logger->info('----------------------------------------------------------------------------------------');
        return $test;
    }
}