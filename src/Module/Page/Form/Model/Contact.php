<?php

declare(strict_types=1);

namespace App\Module\Page\Form\Model;

class Contact
{
    public function __construct(
        public string|null $firstName = null,
        public string|null $lastName = null,
        public string|null $email = null,
        public string|null $phoneNumber = null,
        public string|null $content = null,
    ) {
    }
}
