<?php

namespace Isneezy\Timoneiro\Actions;


interface ActionInterface
{
    public function getTitle(): ?string;
    public function getIcon(): ?string;
    public function getPolicy();
    public function getAttributes();
    public function getRoute($key);
    public function getDefaultRoute();
    public function getDataType(): ?string;
}
