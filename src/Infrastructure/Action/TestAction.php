<?php

namespace Infrastructure\Action;

use Infrastructure\Core\Action\Action;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TestAction extends Action
{
    public function __invoke(Request $request): Response
    {
        return new JsonResponse(['foo' => 'bar']);
    }
}
