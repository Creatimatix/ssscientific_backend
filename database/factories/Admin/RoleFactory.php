<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model  = Role::class;
    public function definition()
    {
        return [
            'role_name' => [array_rand(['Admin','Execute','Customer'])],
            'status' => 1
        ];
    }
}
