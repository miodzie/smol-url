<?php

namespace Database\Factories;

use App\Models\ShortUrl;
use App\Models\ShortUrlLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShortUrlLogFactory extends Factory
{
  public function definition()
  {
    return [
      'ip_address' => $this->faker->ipv4,
    ];
  }

  public function configure()
  {
    return $this->afterCreating(function (ShortUrlLog $log) {
      return $log->short_url_id = ShortUrl::factory()->create()->id;
    });
  }
}
