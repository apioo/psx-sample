<?php

namespace App\Model;

use PSX\Schema\Attribute\Description;

#[Description('Operation message')]
class Message
{
    private ?bool $success;
    private ?string $message;

    public function __construct(?bool $success = null, ?string $message = null)
    {
        $this->success = $success;
        $this->message = $message;
    }

    public function getSuccess(): ?bool
    {
        return $this->success;
    }

    public function setSuccess(bool $success): void
    {
        $this->success = $success;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
