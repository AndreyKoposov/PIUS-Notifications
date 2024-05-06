<?php

namespace App\Http\ApiV1\Modules\Notifications\Tests\Factories;

use App\Domain\Orders\Data\Timeslot;
use App\Http\ApiV1\OpenApiGenerated\Enums\DeliveryStatusEnum;
use Ensi\LaravelTestFactories\BaseApiFactory;

class CreateNotificationRequestFactory extends BaseApiFactory
{
    protected function definition(): array
    {
        return [
            'send_time' => $this->faker->date(),
        ];
    }

    public function make(array $extra = []): array
    {
        return $this->makeArray($extra);
    }
}