<?php

declare(strict_types=1);

namespace Freema\HeurekaAPI;

/**
 * @author Tomáš Grasl <grasl.t@centrum.cz>
 */
interface IContainer
{
    public function hasError(): bool;

    /**
     * @return array<string, mixed>|null
     */
    public function getErrorMessage(): ?array;
}
