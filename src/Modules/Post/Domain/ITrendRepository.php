<?php declare(strict_types=1);

namespace Modules\Post\Domain;

interface ITrendRepository
{
    public function add(string $trend): void;
}
