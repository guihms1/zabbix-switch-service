<?php

namespace App\Services;

use App\Repositories\Contracts\DatacomRepository;
use App\Repositories\Contracts\SwitchRepository;
use App\Services\Contracts\SwitchDataService as SwitchDataServiceContract;

class SwitchDataService implements SwitchDataServiceContract {
    private $datacomRepository;
    private $vpwsGroup;
    private $switchBrand;

    public function __construct(DatacomRepository $datacomRepository)
    {
        $this->datacomRepository = $datacomRepository;
        $this->vpwsGroup = null;
        $this->switchBrand = null;
    }

    public function getData(string $switchBrand, array $data): array
    {
        $this->switchBrand = $switchBrand;

        if ($switchBrand === 'datacom') {
            $data = $this->handle($this->datacomRepository, $data);
        }

        return $data;
    }

    public function handle(SwitchRepository $switchRepository, array $data): array
    {
        $processedData = [];
        $idCounter = 1;
        $switchData = $switchRepository->getData($data);
        $switchData = explode("\n", $switchData['output']);
        $switchData = $this->sanitizeData($switchData);

        foreach ($switchData as $item) {
            $dataToProcess = explode(' ', trim($item));

            if (is_null($this->vpwsGroup)) {
                $this->vpwsGroup = trim($dataToProcess[0]);
            }

            $tempArray = [
                'Id' => $idCounter++,
                'VPWSGroup' => null,
                'VPNName' => null,
                'StatusVPN' => null,
                'Segment1' => null,
                'StatePort' => null,
                'Segment2' => null,
                'PwID' => null,
                'StateMPLS' => null,
            ];

            $tempArray = $this->processSwitchData($dataToProcess, $tempArray);

            if (array_search(null, $tempArray) === false) {
                $processedData[] = $tempArray;
            }
        }

        return $processedData;
    }

    public function sanitizeData(array $switchData): array
    {
        $switchDataTemp = $switchData;

        foreach ($switchData as $mainKey => $mainValue) {
            if ($this->shouldBeRemoved($mainValue)) {
                unset($switchDataTemp[$mainKey]);
            }
        }

        return $switchDataTemp;
    }

    public function shouldBeRemoved(string $data): bool
    {
        $isGarbage = false;
        foreach (explode(' ', $data) as $item) {
            if ($this->isGarbage($item)) {
                $isGarbage = true;
                break;
            }
        }

        return $isGarbage;
    }

    public function isGarbage(string $data): bool
    {
        return in_array($data, config('switchs_commands')[$this->switchBrand]['command_garbage'])
            || str_contains($data, '---------');
    }

    public function processSwitchData(array $dataToProcess, array $tempArray): array
    {
        $tempArray['VPWSGroup'] = $this->vpwsGroup;
        foreach ($dataToProcess as $itemToProcess) {
            if ($itemToProcess === $this->vpwsGroup || $itemToProcess === '') {
                continue;
            }

            $keyToFill = array_search(null, $tempArray);

            if ($keyToFill !== false) {
                $tempArray[$keyToFill] = trim($itemToProcess);
            }
        }

        return $tempArray;
    }
}
