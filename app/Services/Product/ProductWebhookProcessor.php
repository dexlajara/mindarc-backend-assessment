<?php
declare(strict_types=1);

namespace App\Services\Product;

final class ProductWebhookProcessor implements ProductWebhookProcessorInterface
{
    private ProductMapperInterface $productMapper;

    public function __construct(ProductMapperInterface $productMapper)
    {
        $this->productMapper = $productMapper;
    }

    /**
     * {@inheritDoc}
     */
    public function getProducts(array $webhookContent): array
    {
        $products = [];

        foreach ($this->getContentItems($webhookContent) as $item) {
            if ($this->filterOutItem($item) === true) {
                continue;
            }

            $product = $this->productMapper->map($item);
            // $product->save();

            $products[] = $product;
        }

        return $products;
    }

    /**
     * @param mixed[] $webhookContent
     * @return mixed[]
     */
    private function getContentItems(array $webhookContent): array
    {
        return $webhookContent['products']['product'] ?? [];
    }

    /**
     * If filtering logic becomes too complex in the future, consider making this method a separate service.
     *
     * @param mixed[] $data
     */
    private function filterOutItem(array $data): bool
    {
        $tags = \explode(',', $data['tags'] ?? []);

        return \in_array('season|winter', $tags, true);
    }
}
