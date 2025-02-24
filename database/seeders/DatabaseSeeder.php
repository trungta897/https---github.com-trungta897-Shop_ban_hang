<?php

namespace Database\Seeders;

use App\Models\ProductComment;
use App\Models\ProductImages;
use App\Models\Products;
use App\Models\User;
use App\Models\Brands;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::insert([[
            'id' => 1,
            'role' => 'buyer',
            'username' => 'trungta897',
            'email' => 'nguyentatrunghieu2@gmail.com',
            'password' => Hash::make('Trungta897@'),
            'phone' => '0837791414',
            'address' => 'Hanoi, Vietnam',
            'avatar' => 'avatar.jpg',
        ],
        [
            'id' => 2,
            'role' => 'seller',
            'username' => 'root',
            'email' => 'hieunguyentatrung@gmail.com',
            'password' => Hash::make('Asdasdasdasasda1@'),
            'phone' => '0837791414',
            'address' => 'Hanoi, Vietnam',
            'avatar' => 'avatar2.jpg',
        ]
        ]);

        Products::insert([[
            'id' => 1,
            'name' => 'Điện thoại Samsung Galaxy A34 5G 8GB/256GB',
            'brand_id' => 1,
            'price' => 8000500,
            'image' => 'product-2.jpg',
            'detail' => 'dien thoai sam  sung a34',
            'category' => 'Điện thoại',
        ],
        [
            'id' => 2,
            'name' => 'Laptop HP 14s-dq5121TU i3 1215U/8GB/512GB/14inch;FHD/Win11',
            'brand_id' => 2,
            'price' => 16000000,
            'image' => '2022_12_7_638060331277536556_hp-14s-dq-bac-1.jpg',
            'detail' => 'asdasdasdasdasdasd',
            'category' => 'Laptop',
        ],
        [
            'id' => 3,
            'name' => 'Điện thoại Samsung Galaxy A34 5G 8GB/256GB',
            'brand_id' => 1,
            'price' => 8000500,
            'image' => 'product-2.jpg',
            'detail' => 'dien thoai sam  sung a34',
            'category' => 'Điện thoại',
        ],
        [
            'id' => 4,
            'name' => 'Điện thoại Samsung Galaxy A34 5G 8GB/256GB',
            'brand_id' => 1,
            'price' => 8000500,
            'image' => 'product-2.jpg',
            'detail' => 'dien thoai sam  sung a34',
            'category' => 'Điện thoại',
        ]
        ]);

        ProductImages::insert([[
            'id' => 1,
            'product_id' => 1,
            'image' => 'product-2.jpg',
        ],
        [
            'id' => 2,
            'product_id' => 2,
            'image' => '2022_12_7_638060331277536556_hp-14s-dq-bac-1.jpg',
        ],
        [
            'id' => 3,
            'product_id' => 3,
            'image' => 'product-2.jpg',
        ],
        [
            'id' => 4,
            'product_id' => 4,
            'image' => 'product-2.jpg',
        ]
        ]);

        Brands::insert([[
            'id' => 1,
            'name' => 'Samsung',
            'description' => 'Samsung',
            'logo' => 'samsung.jpg',
        ],
        [
            'id' => 2,
            'name' => 'HP',
            'description' => 'HP',
            'logo' => 'hp.jpg',
        ]
        ]);
    }
}
