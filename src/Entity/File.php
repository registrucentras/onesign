<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\Entity;

use RegistruCentras\OneSign\Entity\EntityInterface;

final class File extends AbstractEntity implements EntityInterface
{
    protected ?string $name = null;
    
    protected ?string $content = null;
    
    public function setName(string $name): EntityInterface
    {
        $this->name = $name;
        return $this;
    }
    
    public function getName(): ?string
    {
        return $this->name;
    }
    
    public function setContent(string $content): EntityInterface
    {
        $this->content = $content;
        return $this;
    }
    
    public function getContent(): ?string
    {
        return $this->content;
    }
}
