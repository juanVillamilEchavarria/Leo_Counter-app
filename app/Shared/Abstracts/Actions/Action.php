<?php

namespace App\Shared\Abstracts\Actions;

abstract class Action{

    protected string $throwable;
    public function __construct(
        /** @var class-string<Model> $model */
        protected string $model
    )
    {
    }

    public function setThrowable(string $throwable): void
    {
        $this->throwable = $throwable;
    }

    public function getThrowable(): ?string
    {
        return $this->throwable ?? null;
    }

    public function getModel(): string
    {
        return $this->model;
    }
}