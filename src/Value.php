<?php declare(strict_types=1);

namespace Kiboko\Component\ExpressionLanguage\Akeneo;

final class Value
{
    public function __construct(
        private mixed $value,
        private ?string $scope = null,
        private ?string $locale = null,
    ) {}
    
    public function withScope(string $scope): self
    {
        $this->scope = $scope;
        
        return $this;
    }
    
    public function withoutScope(): self
    {
        $this->scope = null;
        
        return $this;
    }
    
    public function withLocale(string $locale): self
    {
        $this->locale = $locale;
        
        return $this;
    }
    
    public function withoutLocale(): self
    {
        $this->locale = null;
        
        return $this;
    }

    public function asArray(): array
    {
        return [
            'data' => $this->value,
            'scope' => $this->scope,
            'locale' => $this->locale,
        ];
    }
}
