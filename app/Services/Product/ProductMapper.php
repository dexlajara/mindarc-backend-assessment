<?php
declare(strict_types=1);

namespace App\Services\Product;

use App\Models\Product;
use Illuminate\Support\Str;

final class ProductMapper implements ProductMapperInterface
{
    /**
     * {@inheritDoc}
     */
    public function map(array $data): Product
    {
        $product = new Product();
        $product->external_id = $data['id'] ?? null;
        $product->price = $this->formatPrice($data);
        $product->sku = $data['sku'] ?? null;
        $product->tags = $this->formatTags($data);
        $product->title = $this->formatTitle($data);

        return $product;
    }

    /**
     * @param mixed[] $data
     */
    private function formatPrice(array $data): ?string
    {
        if (isset($data['price']) === false) {
            return null;
        }

        return \number_format(\round((float)$data['price'], 3), 3);
    }

    /**
     * @param mixed[] $data
     * @return string[]
     */
    private function formatTags(array $data): array
    {
        if (isset($data['tags']) === false || is_string($data['tags']) === false) {
            return [];
        }

        return \explode(',', $data['tags']);
    }

    /**
     * @param mixed[] $data
     */
    private function formatTitle(array $data): ?string
    {
        if (isset($data['title']) === false || \is_string($data['title']) === false) {
            return null;
        }

        return Str::camel($data['title']);
    }
}
