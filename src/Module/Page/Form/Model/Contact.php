<?php

declare(strict_types=1);

namespace App\Module\Page\Form\Model;

use App\Module\Page\Domain\ContactType;

class Contact
{
    public ContactType $subject;

    public string $firstName;

    public string $lastName;

    public string $email;

    public string|null $phoneNumber;

    public string $content;
}
