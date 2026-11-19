<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public User $user;

    public bool $isAdmin = false;

    // ===== Admin stats
    public int $totalUsers = 0;
    public int $totalProducts = 0;
    public int $totalOrders = 0;
    public int $totalRevenue = 0;

    /** @var array<int, array<string, mixed>> */
    public array $recentOrders = [];

    /** @var array<int, array<string, mixed>> */
    public array $topProducts = [];

    // ===== Customer menu (tabs)
    public string $activeMenu = 'nasi-box'; // nasi-box | prasmanan | tumpeng

    /** @var array<int, array<string, mixed>> */
    public array $products = [];

    /** @var array<int, array<string, mixed>> */
    public array $myOrders = [];

    public int $cartCount = 0;

    /** Map menu slug => nama category di database */
    private array $menuCategoryMap = [
        'nasi-box'   => 'Nasi Box',
        'prasmanan'  => 'Prasmanan',
        'tumpeng'    => 'Nasi Tumpeng',
    ];

    public function mount(): void
    {
        $auth = Auth::user(); // Intelephense paham ini

        if (!$auth instanceof \App\Models\User) {
            abort(403);
        }

        $this->user = $auth;
        $this->isAdmin = ($this->user->role === 'admin');

        if ($this->isAdmin) {
            $this->loadAdminData();
        } else {
            $this->loadCustomerData();
        }
    }

    public function setMenu(string $menu): void
    {
        if (!array_key_exists($menu, $this->menuCategoryMap)) {
            return;
        }

        $this->activeMenu = $menu;
        $this->loadCustomerProducts(); // reload sesuai tab
    }

    private function loadAdminData(): void
    {
        $this->totalUsers = User::query()->where('role', 'customer')->count();
        $this->totalProducts = Product::query()->count();
        $this->totalOrders = Order::query()->count();

        $this->totalRevenue = (int) Order::query()
            ->where('status', 'completed')
            ->sum('total_price');

        $this->recentOrders = Order::query()
            ->with('user')
            ->latest()
            ->limit(6)
            ->get()
            ->map(function (Order $o) {
                return [
                    'id' => $o->id,
                    'status' => $o->status,
                    'total_price' => $o->total_price,
                    'created_at' => optional($o->created_at)->toDateTimeString(),
                    'user' => [
                        'name' => $o->user?->name,
                        'email' => $o->user?->email,
                    ],
                ];
            })
            ->toArray();

        // Kalau relasi orderItems belum ada, comment baris ini atau buat relasinya di Product model.
        $this->topProducts = Product::query()
            ->withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->limit(5)
            ->get()
            ->map(function (Product $p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name ?? ('Product #' . $p->id),
                    'price' => $p->price ?? null,
                    'order_items_count' => (int) ($p->order_items_count ?? 0),
                ];
            })
            ->toArray();
    }

    private function loadCustomerData(): void
    {
        $this->loadCustomerProducts();

        $this->myOrders = Order::query()
            ->where('user_id', $this->user->id)
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn(Order $o) => [
                'id' => $o->id,
                'status' => $o->status,
                'total_price' => $o->total_price,
                'created_at' => optional($o->created_at)->toDateTimeString(),
            ])
            ->toArray();

        $this->cartCount = Cart::query()
            ->where('user_id', $this->user->id)
            ->count();
    }

    private function loadCustomerProducts(): void
    {
        $categoryName = $this->menuCategoryMap[$this->activeMenu] ?? 'Nasi Box';

        $query = Product::query()
            ->where('is_active', true)
            ->with('category')
            ->latest()
            ->limit(12);

        // Filter berdasarkan nama kategori (category.name)
        $query->whereHas('category', function (Builder $q) use ($categoryName) {
            $q->where('name', $categoryName);
        });

        $this->products = $query
            ->get()
            ->map(function (Product $p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name ?? ('Product #' . $p->id),
                    'price' => $p->price ?? null,
                    'image' => $p->image ?? null, // kalau ada kolom image
                    'category' => [
                        'name' => $p->category?->name,
                    ],
                ];
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
