<?php

namespace Database\Seeders;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ──────────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'              => 'Admin',
                'password'          => Hash::make('password'),
                'role'              => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $customers = [
            ['name' => 'Budi Santoso',   'email' => 'budi@example.com'],
            ['name' => 'Siti Rahayu',    'email' => 'siti@example.com'],
            ['name' => 'Andi Wijaya',    'email' => 'andi@example.com'],
            ['name' => 'Dewi Lestari',   'email' => 'dewi@example.com'],
            ['name' => 'Riko Pratama',   'email' => 'riko@example.com'],
            ['name' => 'Pelanggan Demo', 'email' => 'customer@example.com'],
        ];

        foreach ($customers as $c) {
            User::firstOrCreate(
                ['email' => $c['email']],
                [
                    'name'              => $c['name'],
                    'password'          => Hash::make('password'),
                    'role'              => 'customer',
                    'email_verified_at' => now(),
                ]
            );
        }

        // ── Categories ─────────────────────────────────────────
        $categories = [
            'Elektronik', 'Pakaian', 'Makanan & Minuman',
            'Peralatan Rumah', 'Olahraga', 'Buku',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(['name' => $name], ['slug' => Str::slug($name)]);
        }

        // ── Products ───────────────────────────────────────────
        $storagePath = storage_path('app/public/products');
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        $products = [
            // Elektronik
            ['name' => 'Laptop Gaming ASUS ROG',     'category' => 'Elektronik',        'price' => 12500000, 'stock' => 10,  'img' => 'laptop-gaming',    'keyword' => 'laptop'],
            ['name' => 'Smartphone Samsung A54',      'category' => 'Elektronik',        'price' => 4500000,  'stock' => 25,  'img' => 'smartphone',       'keyword' => 'smartphone'],
            ['name' => 'Headphone Sony WH-1000XM5',  'category' => 'Elektronik',        'price' => 3200000,  'stock' => 15,  'img' => 'headphone',        'keyword' => 'headphones'],
            ['name' => 'Tablet iPad Air 5',           'category' => 'Elektronik',        'price' => 9800000,  'stock' => 8,   'img' => 'tablet',           'keyword' => 'tablet'],
            ['name' => 'Smart TV 43 inch',            'category' => 'Elektronik',        'price' => 5500000,  'stock' => 12,  'img' => 'smarttv',          'keyword' => 'television'],
            // Pakaian
            ['name' => 'Kaos Polos Premium',          'category' => 'Pakaian',           'price' => 85000,    'stock' => 100, 'img' => 'kaos',             'keyword' => 'tshirt'],
            ['name' => 'Celana Jeans Slim Fit',       'category' => 'Pakaian',           'price' => 250000,   'stock' => 50,  'img' => 'jeans',            'keyword' => 'jeans'],
            ['name' => 'Jaket Windbreaker',           'category' => 'Pakaian',           'price' => 350000,   'stock' => 30,  'img' => 'jaket',            'keyword' => 'jacket'],
            ['name' => 'Kemeja Batik Modern',         'category' => 'Pakaian',           'price' => 185000,   'stock' => 45,  'img' => 'batik',            'keyword' => 'shirt'],
            ['name' => 'Dress Casual Wanita',         'category' => 'Pakaian',           'price' => 220000,   'stock' => 35,  'img' => 'dress',            'keyword' => 'dress'],
            // Makanan & Minuman
            ['name' => 'Kopi Arabika Gayo 500g',     'category' => 'Makanan & Minuman', 'price' => 125000,   'stock' => 200, 'img' => 'kopi',             'keyword' => 'coffee'],
            ['name' => 'Teh Hijau Premium',           'category' => 'Makanan & Minuman', 'price' => 45000,    'stock' => 150, 'img' => 'teh',              'keyword' => 'tea'],
            ['name' => 'Madu Murni Hutan 500ml',     'category' => 'Makanan & Minuman', 'price' => 95000,    'stock' => 80,  'img' => 'madu',             'keyword' => 'honey'],
            // Peralatan Rumah
            ['name' => 'Blender Philips 1000W',      'category' => 'Peralatan Rumah',   'price' => 450000,   'stock' => 20,  'img' => 'blender',          'keyword' => 'blender'],
            ['name' => 'Rice Cooker 1.8L',           'category' => 'Peralatan Rumah',   'price' => 320000,   'stock' => 18,  'img' => 'rice-cooker',      'keyword' => 'kitchen'],
            ['name' => 'Vacuum Cleaner Portable',    'category' => 'Peralatan Rumah',   'price' => 380000,   'stock' => 22,  'img' => 'vacuum',           'keyword' => 'vacuum'],
            // Olahraga
            ['name' => 'Sepatu Lari Nike Air Max',   'category' => 'Olahraga',          'price' => 1200000,  'stock' => 35,  'img' => 'sepatu-lari',      'keyword' => 'sneakers'],
            ['name' => 'Dumbbell 5kg Set',           'category' => 'Olahraga',          'price' => 280000,   'stock' => 40,  'img' => 'dumbbell',         'keyword' => 'dumbbell'],
            ['name' => 'Matras Yoga Premium',        'category' => 'Olahraga',          'price' => 175000,   'stock' => 60,  'img' => 'yoga-mat',         'keyword' => 'yoga'],
            // Buku
            ['name' => 'Buku Laravel 11',            'category' => 'Buku',              'price' => 175000,   'stock' => 60,  'img' => 'buku-laravel',     'keyword' => 'programming,book'],
            ['name' => 'Buku Clean Code',            'category' => 'Buku',              'price' => 220000,   'stock' => 45,  'img' => 'buku-cleancode',   'keyword' => 'book'],
            ['name' => 'Buku UI/UX Design',          'category' => 'Buku',              'price' => 195000,   'stock' => 30,  'img' => 'buku-uiux',        'keyword' => 'design,book'],
        ];

        foreach ($products as $p) {
            $category = Category::where('name', $p['category'])->first();
            $filename  = 'products/' . $p['img'] . '.jpg';
            $localPath = $storagePath . '/' . $p['img'] . '.jpg';
            $imageUrl  = 'https://loremflickr.com/400/400/' . $p['keyword'] . '?lock=' . crc32($p['img']);

            try {
                $ctx       = stream_context_create(['http' => ['timeout' => 10, 'follow_location' => true]]);
                $imageData = @file_get_contents($imageUrl, false, $ctx);
                if ($imageData !== false && strlen($imageData) > 1000) {
                    file_put_contents($localPath, $imageData);
                } else {
                    $filename = null;
                }
            } catch (\Exception $e) {
                $filename = null;
            }

            Product::firstOrCreate(
                ['slug' => Str::slug($p['name'])],
                [
                    'category_id' => $category->id,
                    'name'        => $p['name'],
                    'description' => 'Produk ' . $p['name'] . ' berkualitas tinggi dengan harga terjangkau. Garansi resmi dan pengiriman cepat ke seluruh Indonesia.',
                    'price'       => $p['price'],
                    'stock'       => $p['stock'],
                    'image'       => $filename,
                    'is_active'   => true,
                ]
            );
        }

        // ── Demo Orders ────────────────────────────────────────
        if (Order::count() > 0) return;

        $customerUsers = User::where('role', 'customer')->get();
        $allProducts   = Product::all();

        $demoOrders = [
            ['user' => 'budi@example.com',     'status' => 'done',      'days_ago' => 10, 'items' => ['Laptop Gaming ASUS ROG', 'Headphone Sony WH-1000XM5']],
            ['user' => 'siti@example.com',     'status' => 'shipped',   'days_ago' => 3,  'items' => ['Dress Casual Wanita', 'Kaos Polos Premium']],
            ['user' => 'andi@example.com',     'status' => 'paid',      'days_ago' => 1,  'items' => ['Buku Laravel 11', 'Buku Clean Code']],
            ['user' => 'dewi@example.com',     'status' => 'pending',   'days_ago' => 0,  'items' => ['Matras Yoga Premium', 'Dumbbell 5kg Set']],
            ['user' => 'riko@example.com',     'status' => 'cancelled', 'days_ago' => 5,  'items' => ['Smart TV 43 inch']],
            ['user' => 'customer@example.com', 'status' => 'done',      'days_ago' => 7,  'items' => ['Kopi Arabika Gayo 500g', 'Teh Hijau Premium', 'Madu Murni Hutan 500ml']],
            ['user' => 'budi@example.com',     'status' => 'shipped',   'days_ago' => 2,  'items' => ['Sepatu Lari Nike Air Max']],
            ['user' => 'siti@example.com',     'status' => 'paid',      'days_ago' => 1,  'items' => ['Smartphone Samsung A54']],
        ];

        $addresses = [
            'Jl. Sudirman No. 45, Jakarta Pusat, DKI Jakarta 10220',
            'Jl. Gatot Subroto No. 12, Bandung, Jawa Barat 40135',
            'Jl. Malioboro No. 78, Yogyakarta, DIY 55271',
            'Jl. Pemuda No. 23, Surabaya, Jawa Timur 60271',
            'Jl. Ahmad Yani No. 56, Medan, Sumatera Utara 20111',
        ];

        foreach ($demoOrders as $i => $o) {
            $user  = User::where('email', $o['user'])->first();
            $items = [];
            $total = 0;

            foreach ($o['items'] as $productName) {
                $product = Product::where('name', $productName)->first();
                if ($product) {
                    $qty     = rand(1, 2);
                    $items[] = ['product' => $product, 'quantity' => $qty, 'price' => $product->price];
                    $total  += $product->price * $qty;
                }
            }

            if (empty($items)) continue;

            $order = Order::create([
                'user_id'          => $user->id,
                'total_price'      => $total,
                'status'           => $o['status'],
                'shipping_address' => $addresses[$i % count($addresses)],
                'phone'            => '08' . rand(100000000, 999999999),
                'payment_ref'      => in_array($o['status'], ['paid', 'shipped', 'done']) ? 'TXN-' . strtoupper(Str::random(10)) : null,
                'created_at'       => now()->subDays($o['days_ago']),
                'updated_at'       => now()->subDays($o['days_ago']),
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['product']->id,
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                ]);
            }
        }
    }
}
