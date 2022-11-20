<?php

namespace Zhuldyz\RecipeSenderPhpMicroservice\internal\entity;

class Mail
{
    private ?int $id;
    private string $letter;

    /**
     * @param int|null $id
     * @param string $letter
     */
    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->letter = $data['letter'] ?? null;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getLetter(): string
    {
        return $this->letter;
    }

    /**
     * @param string $letter
     */
    public function setLetter(string $letter): void
    {
        $this->letter = $letter;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'letter' => $this->getLetter()
        ];
    }

}

