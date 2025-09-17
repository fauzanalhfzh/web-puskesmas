<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pasien>
 */
class PasienFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik' => $this->faker->unique()->numerify('327###########'), // 16 digit NIK
            'nama_lengkap' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password123'), // default password
            'Jenis_Kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'tanggal_lahir' => $this->faker->dateTimeBetween('-70 years', '-17 years')->format('Y-m-d'),
            'alamat' => $this->faker->address(),
            'no_telepon' => $this->faker->optional()->phoneNumber(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
