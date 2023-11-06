<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = Product::create([
            'name' => 'Burger',]);
        $data = $this->getData();
        foreach ($data as $item) {
            $ingredient =  Ingredient::create([
                'name' => $item['name'],
                'stock' => $item['stock'],
                'initial_stock' => $item['initial_stock'],
            ]);
            $product->ingredients()->attach([
                $ingredient->id => ['amount' => $item['amount']],
            ]);
        }
    }
    private function getData()
    {
        return [
            [
                'name' => 'Beef',
                'stock' => 20,
                'initial_stock' => 20,
                'amount' => 150,
            ],
            [
                'name' => 'Cheese',
                'stock' => 5,
                'initial_stock' => 5,
                'amount' => 30,
            ],
            [
                'name' => 'Onion',
                'stock' => 1,
                'initial_stock' => 1,
                'amount' => 20,
            ],
        ];

    }
}
