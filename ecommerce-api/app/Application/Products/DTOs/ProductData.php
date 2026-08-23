<?php
namespace App\Application\Products\DTOs;

class ProductData
{
    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly ?string $description,
        public readonly float $price,
        public readonly ?float $salePrice,
        public readonly ?string $saleEndsAt,
        public readonly int $sku,
        public readonly int $stock,
        public readonly string $categoryId,
        public readonly bool $isActive = true,
        public readonly array $variants = [],
        public readonly array $images = []
    ) {}

    public static function fromArray(array $data, ?self $existing = null): self
    {
        return new self(
            name: $data['name'] ?? $existing?->name ?? '',
            slug: isset($data['name']) ? \Str::slug($data['name']) : ($data['slug'] ?? $existing?->slug ?? ''),
            description: $data['description'] ?? $existing?->description ?? null,
            price: isset($data['price']) ? (float) $data['price'] : ($existing?->price ?? 0.0),
            salePrice: array_key_exists('sale_price', $data) 
                ? ($data['sale_price'] !== null ? (float) $data['sale_price'] : null) 
                : $existing?->salePrice,
            saleEndsAt: $data['sale_ends_at'] ?? $existing?->saleEndsAt ?? null,
            sku: isset($data['sku']) ? (int) $data['sku'] : ($existing?->sku ?? 0),
            stock: isset($data['stock']) ? (int) $data['stock'] : ($existing?->stock ?? 0),
            categoryId: $data['category_id'] ?? $existing?->categoryId ?? '',
            isActive: isset($data['is_active']) ? (bool) $data['is_active'] : ($existing?->isActive ?? true),
            variants: $data['variants'] ?? $existing?->variants ?? [],
            images: $data['images'] ?? $existing?->images ?? []
        );
    }
}
<? 
