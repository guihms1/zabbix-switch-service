<?php

namespace App\Repositories;

use App\Libraries\Contracts\Ssh;
use App\Repositories\Contracts\DatacomRepository as DatacomRepositoryContract;

class DatacomRepository extends SwitchRepository implements DatacomRepositoryContract
{
    private $sshLib;

    public function __construct(Ssh $sshLib)
    {
        $this->sshLib = $sshLib;
    }

    public function getData(array $data): array
    {
        $this->sshLib->connect($data['ip']);
        $this->sshLib->auth($data['user'], $data['password']);
        $this->sshLib->execute(config('switchs_commands.datacom'));

        $data = $this->sshLib->getOutput();

        $this->sshLib->disconnect();

        return $data;
    }
}
