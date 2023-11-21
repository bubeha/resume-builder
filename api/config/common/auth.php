<?php

declare(strict_types=1);


use App\Auth\Domain\Manager\JwtTokenManager as JwtTokenManagerInterface;
use App\Auth\Infrastructure\Manager\JwtTokenManager;

return [
    JwtTokenManagerInterface::class => static function () {
        return  new JwtTokenManager();
    }
];