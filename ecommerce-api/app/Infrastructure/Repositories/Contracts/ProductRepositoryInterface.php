namespace App\Infrastructure\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator;
        public function findById(string $id): ?Product;
            public function create(array $data): Product;
                public function update(string $id, array $data): bool;
                    public function delete(string $id): bool;
                        public function checkAndLockStock(Collection $items): void;
                            public function decrementStock(Collection $items): void;
                            }
                            