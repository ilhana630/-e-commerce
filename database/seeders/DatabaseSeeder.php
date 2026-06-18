<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'              => 'Admin',
                'password'          => Hash::make('password'),
                'role'              => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Sample customer
        User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name'              => 'Pelanggan Demo',
                'password'          => Hash::make('password'),
                'role'              => 'customer',
                'email_verified_at' => now(),
            ]
        );

        // Categories
        $categories = [
            'Elektronik', 'Pakaian', 'Makanan & Minuman',
            'Peralatan Rumah', 'Olahraga', 'Buku',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(['name' => $name], ['slug' => Str::slug($name)]);
        }

        // Pastikan folder storage tersedia
        $storagePath = storage_path('app/public/products');
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        // Sample products dengan gambar sesuai kategori dari loremflickr.com
        $products = [
            ['name' => 'Laptop Gaming ASUS',    'category' => 'Elektronik',        'price' => 12500000, 'stock' => 10,  'img' => 'laptop-gaming',    'keyword' => 'laptop'],
            ['name' => 'Smartphone Samsung A54', 'category' => 'Elektronik',        'price' => 4500000,  'stock' => 25,  'img' => 'smartphone',       'keyword' => 'smartphone'],
            ['name' => 'Headphone Sony WH-1000', 'category' => 'Elektronik',        'price' => 3200000,  'stock' => 15,  'img' => 'headphone',        'keyword' => 'headphones'],
            ['name' => 'Kaos Polos Premium',     'category' => 'Pakaian',           'price' => 85000,    'stock' => 100, 'img' => 'kaos',             'keyword' => 'tshirt'],
            ['name' => 'Celana Jeans Slim Fit',  'category' => 'Pakaian',           'price' => 250000,   'stock' => 50,  'img' => 'jeans',            'keyword' => 'jeans'],
            ['name' => 'Jaket Windbreaker',      'category' => 'Pakaian',           'price' => 350000,   'stock' => 30,  'img' => 'jaket',            'keyword' => 'jacket'],
            ['name' => 'Kopi Arabika Gayo 500g', 'category' => 'Makanan & Minuman', 'price' => 125000,   'stock' => 200, 'img' => 'kopi',             'keyword' => 'coffee'],
            ['name' => 'Teh Hijau Premium',      'category' => 'Makanan & Minuman', 'price' => 45000,    'stock' => 150, 'img' => 'teh',              'keyword' => 'tea'],
            ['name' => 'Blender Philips 1000W',  'category' => 'Peralatan Rumah',   'price' => 450000,   'stock' => 20,  'img' => 'blender',          'keyword' => 'blender'],
            ['name' => 'Rice Cooker 1.8L',       'category' => 'Peralatan Rumah',   'price' => 320000,   'stock' => 18,  'img' => 'rice-cooker',      'keyword' => 'kitchen'],
            ['name' => 'Sepatu Lari Nike',       'category' => 'Olahraga',          'price' => 1200000,  'stock' => 35,  'img' => 'sepatu-lari',      'keyword' => 'sneakers'],
            ['name' => 'Dumbbell 5kg Set',       'category' => 'Olahraga',          'price' => 280000,   'stock' => 40,  'img' => 'dumbbell',         'keyword' => 'dumbbell'],
            ['name' => 'Buku Laravel 11',        'category' => 'Buku',              'price' => 175000,   'stock' => 60,  'img' => 'buku-laravel',     'keyword' => 'programming,book'],
            ['name' => 'Buku Clean Code',        'category' => 'Buku',              'price' => 220000,   'stock' => 45,  'img' => 'buku-cleancode',   'keyword' => 'book'],
        ];

        foreach ($products as $p) {
            $category = Category::where('name', $p['category'])->first();

            // Download gambar dari loremflickr.com sesuai keyword produk
            $filename  = 'products/' . $p['img'] . '.jpg';
            $localPath = $storagePath . '/' . $p['img'] . '.jpg';
            $imageUrl  = 'https://loremflickr.com/400/400/' . $p['keyword'] . '?lock=' . crc32($p['img']);

            try {
                $ctx = stream_context_create(['http' => ['timeout' => 10, 'follow_location' => true]]);
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
                    'description' => 'Deskripsi produk ' . $p['name'] . '. Produk berkualitas tinggi dengan harga terjangkau.',
                    'price'       => $p['price'],
                    'stock'       => $p['stock'],
                    'image'       => $filename,
                    'is_active'   => true,
                ]
            );
        }
    }
}
