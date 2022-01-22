<?php
declare(strict_types=1);

namespace App\Services\Product;

use App\Models\Product;

interface ProductMapperInterface
{
    /**
     * @param mixed[] $data
     */
    public function map(array $data): Product;
}
