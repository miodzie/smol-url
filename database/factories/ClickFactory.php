<?php

namespace Database\Factories;

use App\Models\TinyUrl;
use App\Models\Click;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClickFactory extends Factory
{
  public function definition()
  {
    return [
      'ip_address' => $this->faker->ipv4,
    ];
  }

  public function configure()
  {
    return $this->afterCreating(function (Click $log) {
      return $log->tiny_url_id = TinyUrl::factory()->create()->id;
    });
  }
}
