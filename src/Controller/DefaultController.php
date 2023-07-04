<?php

namespace App\Controller;

use App\Entity\Bar;
use App\Entity\Baz;
use App\Entity\Foo;
use App\Repository\FooRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Proxy\ProxyGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\CacheWarmer\ProxyCacheWarmer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app')]
    public function index(FooRepository $fooRepository): JsonResponse
    {
        $foo = $fooRepository->find(5);
        $clone = clone $foo;
        $bar = $foo->getBar();
        dump(initial: $foo, clone: $clone);

        $barClone = clone $bar;
        foreach ($bar->getBazs() as $baz) {
            $barClone->addBaz(clone $baz);
        }
        $clone->setBar($barClone);

        dump(wrongClone: $clone);

        $fooRepository->save($clone, true);

        return $this->json(
            [
                'message' => 'Cloned',
            ]
        );
    }
}
