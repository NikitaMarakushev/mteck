<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Controller\Product;

use App\Product\Application\Command\Product\CreateProductCommand;
use App\Product\Application\DTO\ProductDTO;
use App\Product\Application\DTO\ProductFormDTO;
use App\Product\Infrastructure\Form\ProductType;
use App\Core\Application\Command\CommandBusInterface;
use App\Core\Infrastructure\Tools\BootstrapType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product/new', name: 'create_product', methods: ['GET', 'POST'])]
class CreateProductAction extends AbstractController
{
    public function __invoke(
        Request $request,
        CommandBusInterface $commandBus,
    ): Response {
        $productFromDTO = new ProductFormDTO();
        $form = $this->createForm(ProductType::class, $productFromDTO, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new CreateProductCommand(
                $productFromDTO->getName(),
                $productFromDTO->getDescription(),
                $productFromDTO->getPrice(),
                $productFromDTO->getImage()
            );

            $productId = $commandBus->execute($command);

            $this->addFlash(
                BootstrapType::BOOTSTRAP_TYPE_SUCCESS,
                "Продукт {$productFromDTO->getName()} сохранен"
            );

            return $this->redirectToRoute('list_product', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/create_product.html.twig', [
            'product' => $productFromDTO,
            'form' => $form,
        ]);
    }
}