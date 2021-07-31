<?php

namespace App\Services\Ssh;

use App\Services\Contracts\SshService as SshServiceContract;
use InvalidArgumentException;
use Exception;

class SshService implements SshServiceContract
{
    private $connection;
    private $stream;

    public function connect(string $host): void
    {
        if (!$host) {
            throw new InvalidArgumentException('Host information is missing.');
        }

        $this->connection = ssh2_connect($host);

        if (!$this->connection) {
            throw new Exception('Connection faild. Please, check if the host information was correct.');
        }
    }

    public function auth(string $user, string $password): void
    {
        if (!$this->connection) {
            throw new Exception('The connection is not set yet.');
        }
        if (!$user || $password) {
            throw new InvalidArgumentException('User and password required.');
        }
        ssh2_auth_password($this->connection, $user, $password);
    }

    public function execute(string $command): void
    {
        $this->stream = ssh2_exec($this->connection, $command);

        if (!$this->stream) {
            throw new Exception('Command execution failed. Please, check the data provided and the host firewall.');
        }
    }

    public function getOutput(): array
    {
        stream_set_blocking($this->stream, true);

        $output = ssh2_fetch_stream($this->stream, SSH2_STREAM_STDIO);
        $errors = ssh2_fetch_stream($this->stream, SSH2_STREAM_STDERR);

        $output = stream_get_contents($output);
        $errors = stream_get_contents($errors);

        stream_set_blocking($this->stream, false);

        return [
            'output' => $output,
            'errors' => $errors
        ];
    }

    public function disconnect(): void
    {
        if ($this->connection) {
            ssh2_disconnect($this->connection);
        }
    }
}
