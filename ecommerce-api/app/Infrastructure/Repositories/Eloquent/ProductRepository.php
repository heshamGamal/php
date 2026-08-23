<?php
namespace App\Infrastructure\Repositories\Eloquent;

use App\Infrastructure\Repositories\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Product::with(['category', 'variants', 'media'])->latest();

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }
        if (isset($filters['is_active'])) {
            $query->where('is_active', filter_var($filters['is_active'], FILTER_VALIDATE_BOOLEAN));
        }
        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        return $query->paginate($perPage);
    }

    public function findById(string $id): ?Product
    {
        return Product::with(['category', 'variants', 'media'])->find($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(string $id, array $data): bool
    {
        $product = Product::find($id);
        return $product ? $product->update($data) : false;
    }

    public function delete(string $id): bool
    {
        $product = Product::find($id);
        return $product ? $product->delete() : false;
    }

    public function syncVariants(string $productId, array $variants): void
    {
        ProductVariant::where('product_id', $productId)->delete();

        foreach ($variants as $variant) {
            ProductVariant::create([
                'product_id' => $productId,
                'attributes' => is_array($variant['attributes'] ?? null) 
                    ? json_encode($variant['attributes']) 
                    : ($variant['attributes'] ?? '{}'),
                'price'      => $variant['price'] ?? null,
                'stock'      => (int) ($variant['stock'] ?? 0),
                'sku'        => (int) ($variant['sku'] ?? 0),
            ]);
        }
    }

    public function adjustStock(string $productId, int $quantityChange): bool
    {
        $product = Product::find($productId);
        if (!$product) {
            return false;
        }

        if (($product->stock + $quantityChange) < 0) {
            throw new \InvalidArgumentException("عذراً، لا يمكن خفض المخزون إلى ما دون الصفر.");
        }

        $product->stock += $quantityChange;
        return $product->save();
    }

    public function bulkUpdateStatus(array $productIds, bool $isActive): int
    {
        return Product::whereIn('id', $productIds)->update(['is_active' => $isActive]);
    }

    public function bulkDelete(array $productIds): int
    {
        return Product::whereIn('id', $productIds)->delete();
    }
}
?> 

