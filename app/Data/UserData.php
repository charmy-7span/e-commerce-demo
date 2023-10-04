<?php

namespace App\Data;

use DateTime;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Unique;

class UserData extends Data
{
    public function __construct(
        public ?int $id,
        #[Max(10)]
        public string $first_name,
        public string $last_name,
        #[Email,
        Unique('users', 'email')]
        public string $email,
        public string $mobile_number,
        public ?string $password,
        public ?DateTime $created_at
    ) {
    }
}
