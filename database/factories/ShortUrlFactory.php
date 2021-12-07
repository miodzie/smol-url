<?php

namespace Database\Factories;

use App\Models\ShortUrl;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShortUrlFactory extends Factory
{
  public function definition()
  {
    return [
      'full_url' => $this->faker->url,
      'token' => ShortUrl::generateUniqueToken(),
    ];
  }
}
