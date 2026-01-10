<?php

declare(strict_types=1);

namespace App\Website\Form\Model;

use App\Website\Domain\ContactType;

class Contact
{
    public ContactType $subject;

    public string $firstName;

    public string $lastName;

    public string $email;

    public string|null $phoneNumber = null;

    public string $content;
}
