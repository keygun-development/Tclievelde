<?php

namespace functions\core;

interface CustomTypeInterface
{
    public static function getType(): string;

    public function getObjectClass(): string;

    public function registerType(): void;

    public function registerCustomFields(): void;
}
