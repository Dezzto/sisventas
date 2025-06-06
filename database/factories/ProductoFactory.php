<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo' => $this->faker->unique()->ean13(), // Código único
            'nombre' => $this->faker->word(), // Nombre aleatorio
            'descripcion' => $this->faker->sentence(), // Descripción aleatoria
            'imagen' => $this->faker->imageUrl(640, 480, 'products', true), // URL de una imagen aleatoria
            'stock' => $this->faker->numberBetween(10, 100), // Stock entre 10 y 100
            'stock_minimo' => $this->faker->numberBetween(5, 10), // Stock mínimo entre 5 y 10
            'stock_maximo' => $this->faker->numberBetween(50, 200), // Stock máximo entre 50 y 200
            'precio_compra' => $this->faker->randomFloat(2, 10, 500), // Precio de compra entre 10 y 500
            'precio_venta' => $this->faker->randomFloat(2, 20, 600), // Precio de venta entre 20 y 600
            'fecha_ingreso' => $this->faker->date(), // Fecha de ingreso aleatoria
            'categoria_id' => 3, // Relación con la tabla categorías
            'empresa_id' => 1,
        ];
    }
}
