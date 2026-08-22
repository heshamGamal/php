namespace App\Application\Products\Services;

use App\Application\Products\DTOs\ProductData;
use App\Infrastructure\Repositories\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    public function __construct(
            private readonly ProductRepositoryInterface $productRepository
                ) {}

                    public function getCatalogProducts(int $perPage = 15): LengthAwarePaginator
                        {
                                return $this->productRepository->getAllPaginated($perPage);
                                    }

                                        public function getProductDetails(string $id): Product
                                            {
                                                    $product = $this->productRepository->findById($id);
                                                            
                                                                    if (!$product) {
                                                                                throw new \Illuminate\Database\Eloquent\ModelNotFoundException("المنتج غير موجود.");
                                                                                        }

                                                                                                return $product;
                                                                                                    }

                                                                                                        public function createNewProduct(ProductData $dto): Product
                                                                                                            {
                                                                                                                    return $this->productRepository->create([
                                                                                                                                'name'        => $dto->name,
                                                                                                                                            'slug'        => $dto->slug,
                                                                                                                                                        'description' => $dto->description,
                                                                                                                                                                    'price'       => $dto->price,
                                                                                                                                                                                'sale_price'  => $dto->salePrice,
                                                                                                                                                                                            'sku'         => $dto->sku,
                                                                                                                                                                                                        'stock'       => $dto->stock,
                                                                                                                                                                                                                    'category_id' => $dto->categoryId,
                                                                                                                                                                                                                                'is_active'   => $dto->isActive,
                                                                                                                                                                                                                                        ]);
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                            