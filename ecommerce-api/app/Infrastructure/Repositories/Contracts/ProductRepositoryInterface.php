<?php
namespace App\Infrastructure\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function getAllPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator;
    public function findById(string $id): ?Product;
    public function create(array $data): Product;
    public function update(string $id, array $data): bool;
    public function delete(string $id): bool;
    
    public function syncVariants(string $productId, array $variants): void;
    public function adjustStock(string $productId, int $quantityChange): bool;
    public function bulkUpdateStatus(array $productIds, bool $isActive): int;
    public function bulkDelete(array $productIds): int;
}
?> 
