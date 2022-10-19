<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Controller\Product;

use App\Product\Application\Command\Product\CreateProductCommand;
use App\Product\Application\DTO\ProductFormDTO;
use App\Product\Domain\Service\ProductCategoryChoiceHelper;
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
        ProductCategoryChoiceHelper $productCategoryChoiceHelper
    ): Response {
        $productFormDTO = new ProductFormDTO();
        $form = $this->createForm(ProductType::class, $productFormDTO, []);

        $form = $this->createForm(ProductType::class, $productFormDTO, [
            'categories_choices' => $productCategoryChoiceHelper->getChoices()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new CreateProductCommand(
                $productFormDTO->getName(),
                $productFormDTO->getDescription(),
                $productFormDTO->getPrice(),
                $productFormDTO->getImage(),
                $productFormDTO->getCategory()
            );

            $commandBus->execute($command);

            $this->addFlash(
                BootstrapType::BOOTSTRAP_TYPE_SUCCESS,
                "Продукт {$productFormDTO->getName()} сохранен"
            );

            return $this->redirectToRoute('list_product', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/create_product.html.twig', [
            'product' => $productFormDTO,
            'form' => $form,
        ]);
    }
}