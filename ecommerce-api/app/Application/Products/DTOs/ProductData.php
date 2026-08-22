namespace App\Application\Products\DTOs;

class ProductData
{
    public function __construct(
            public readonly string $name,
                    public readonly string $slug,
                            public readonly ?string $description,
                                    public readonly float $price,
                                            public readonly ?float $salePrice,
                                                    public readonly int $sku,
                                                            public readonly int $stock,
                                                                    public readonly string $categoryId,
                                                                            public readonly bool $isActive = true,
                                                                                    public readonly array $attributes = []
                                                                                        ) {}

                                                                                            public static function fromRequest(array $data): self
                                                                                                {
                                                                                                        return new self(
                                                                                                                    name: $data['name'],
                                                                                                                                slug: $data['slug'] ?? \Str::slug($data['name']),
                                                                                                                                            description: $data['description'] ?? null,
                                                                                                                                                        price: (float) $data['price'],
                                                                                                                                                                    salePrice: isset($data['sale_price']) ? (float) $data['sale_price'] : null,
                                                                                                                                                                                sku: (int) $data['sku'],
                                                                                                                                                                                            stock: (int) $data['stock'],
                                                                                                                                                                                                        categoryId: $data['category_id'],
                                                                                                                                                                                                                    isActive: $data['is_active'] ?? true,
                                                                                                                                                                                                                                attributes: $data['attributes'] ?? []
                                                                                                                                                                                                                                        );
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                            