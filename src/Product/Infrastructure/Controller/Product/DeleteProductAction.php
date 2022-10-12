<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Controller\Product;

use App\Core\Application\Command\CommandBusInterface;
use App\Core\Infrastructure\Tools\BootstrapType;
use App\Product\Application\Command\Product\DeleteCustomerCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product/{id}', name: 'delete_product', methods: ['POST'])]
class DeleteProductAction extends AbstractController
{
    public function __invoke(Request $request, int $id, CommandBusInterface $commandBus): Response
    {
        if ($this->isCsrfTokenValid('delete'.$id, $request->request->get('_token'))) {
            $command = new DeleteCustomerCommand($id);
            $commandBus->execute($command);

            $this->addFlash(
                BootstrapType::BOOTSTRAP_TYPE_SUCCESS,
                'Продукт удален'
            );
        }

        return $this->redirectToRoute('list_product', [], Response::HTTP_SEE_OTHER);
    }
}