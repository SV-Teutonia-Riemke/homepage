<?php

declare(strict_types=1);

namespace App\Module\Page\Form\Model;

class Contact
{
    public string $subject;

    public string $firstName;

    public string $lastName;

    public string $email;

    public string|null $phoneNumber;

    public string $content;
}
