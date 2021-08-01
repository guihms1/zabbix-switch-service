<?php

namespace App\Libraries\Contracts;

interface Ssh
{
    public function connect(string $host): void;
    public function auth(string $user, string $password): void;
    public function execute(string $command): void;
    public function getOutput(): array;
    public function disconnect(): void;
}
