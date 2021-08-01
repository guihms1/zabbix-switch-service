<?php

namespace App\Repositories;

use App\Libraries\Contracts\Ssh;
use App\Repositories\Contracts\DatacomRepository as DatacomRepositoryContract;

class DatacomRepository extends SwitchRepository implements DatacomRepositoryContract
{
    private $sshService;

    public function __construct(Ssh $sshService)
    {
        $this->sshService = $sshService;
    }

    public function getData(array $data): array
    {
        $this->sshService->connect($data['ip']);
        $this->sshService->auth($data['user'], $data['password']);
        $this->sshService->execute(config('switchs_commands.datacom'));

        return $this->sshService->getOutput();
    }
}
