<?php

namespace Database\Factories;

use App\Models\TinyUrl;
use Illuminate\Database\Eloquent\Factories\Factory;

class TinyUrlFactory extends Factory
{
  public function definition()
  {
    return [
      'url' => $this->faker->url(),
      'token' => TinyUrl::generateUniqueToken(),
    ];
  }
}
