<?php

namespace App\Shared\Abstracts\Actions;

abstract class Action{

    protected string $throable;
    public function __construct(
        /** @var class-string<Model> $model */
        protected string $model
    )
    {
    }

    public function setThroable(string $throable): void
    {
        $this->throable = $throable;
    }

    public function getThroable(): ?string
    {
        return $this->throable ?? null;
    }

    public function getModel(): string
    {
        return $this->model;
    }
}