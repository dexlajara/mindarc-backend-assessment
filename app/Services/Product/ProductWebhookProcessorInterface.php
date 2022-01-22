<?php
declare(strict_types=1);

namespace App\Services\Product;

use App\Models\Product;

interface ProductWebhookProcessorInterface
{
    /**
     * @param mixed[] $webhookContent
     * @return \App\Models\Product[]
     */
    public function getProducts(array $webhookContent): array;
}
