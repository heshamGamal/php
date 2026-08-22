namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Application\Products\Services\ProductService;
use App\Application\Products\DTOs\ProductData;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(
            private readonly ProductService $productService
                ) {}

                    public function index(): JsonResponse
                        {
                                $products = $this->productService->getCatalogProducts();
                                        return response()->json(['status' => 'success', 'data' => $products]);
                                            }

                                                public function show(string $id): JsonResponse
                                                    {
                                                            $product = $this->productService->getProductDetails($id);
                                                                    return response()->json(['status' => 'success', 'data' => $product]);
                                                                        }

                                                                            public function store(Request $request): JsonResponse
                                                                                {
                                                                                        $validated = $request->validate([
                                                                                                    'name'        => 'required|string|max:255',
                                                                                                                'price'       => 'required|numeric|min:0',
                                                                                                                            'sale_price'  => 'nullable|numeric|min:0',
                                                                                                                                        'sku'         => 'required|integer',
                                                                                                                                                    'stock'       => 'required|integer|min:0',
                                                                                                                                                                'category_id' => 'required|uuid|exists:categories,id',
                                                                                                                                                                        ]);

                                                                                                                                                                                $dto = ProductData::fromRequest($validated);
                                                                                                                                                                                        $product = $this->productService->createNewProduct($dto);

                                                                                                                                                                                                return response()->json(['status' => 'success', 'data' => $product], 201);
                                                                                                                                                                                                    }
                                                                                                                                                                                                    }
                                                                                                                                                                                                    