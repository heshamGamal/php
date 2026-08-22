namespace App\Infrastructure\Repositories\Eloquent;

use App\Models\Product;
use App\Infrastructure\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
        {
                return Product::where('is_active', true)
                            ->with(['category', 'media'])
                                        ->latest()
                                                    ->paginate($perPage);
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
                                                                                                                $product = $this->findById($id);
                                                                                                                        return $product ? $product->update($data) : false;
                                                                                                                            }

                                                                                                                                public function delete(string $id): bool
                                                                                                                                    {
                                                                                                                                            $product = $this->findById($id);
                                                                                                                                                    return $product ? $product->delete() : false;
                                                                                                                                                        }

                                                                                                                                                            public function checkAndLockStock(Collection $items): void
                                                                                                                                                                {
                                                                                                                                                                        foreach ($items as $item) {
                                                                                                                                                                                    $product = Product::where('id', $item->product_id)->lockForUpdate()->first();
                                                                                                                                                                                                if (!$product || $product->stock < $item->quantity) {
                                                                                                                                                                                                                throw new \Exception("المخزون غير كافٍ للمنتج: " . ($product?->name ?? 'غير معروف'));
                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                            public function decrementStock(Collection $items): void
                                                                                                                                                                                                                                                {
                                                                                                                                                                                                                                                        foreach ($items as $item) {
                                                                                                                                                                                                                                                                    Product::where('id', $item->product_id)->decrement('stock', $item->quantity);
                                                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                