<?php

declare(strict_types=1);

use App\Shared\Infrastructure\Validator\Validator;
use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

return [ValidatorInterface::class => static fn (): ValidatorInterface => Validation::createValidatorBuilder()
    ->enableAnnotationMapping()
    ->setTranslationDomain('validators')
    ->getValidator(), Validator::class => static fn (ContainerInterface $container) => new Validator($container->get(ValidatorInterface::class))];
