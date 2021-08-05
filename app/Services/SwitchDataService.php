<?php

namespace App\Services;

use App\Repositories\Contracts\DatacomRepository;
use App\Repositories\Contracts\SwitchRepository;
use App\Services\Contracts\SwitchDataService as SwitchDataServiceContract;

class SwitchDataService implements SwitchDataServiceContract {
    private $datacomRepository;
    private $vpwsGroup;

    public function __construct(DatacomRepository $datacomRepository)
    {
        $this->datacomRepository = $datacomRepository;
        $this->vpwsGroup = null;
    }

    public function getData(string $switchBrand, array $data): array
    {
        if ($switchBrand === 'datacom') {
            $data = $this->handle($this->datacomRepository, $data);
        }

        return $data;
    }

    public function handle(SwitchRepository $switchRepository, array $data): array
    {
        $processedData = [];
        $switchData = $switchRepository->getData($data);
        $switchData = explode("\n", $switchData['output']);

        if (count($switchData) > 3) {
            array_splice($switchData, 0, 2);
        }

        foreach ($switchData as $item) {
            $dataToProcess = explode(" ", trim($item));

            if (is_null($this->vpwsGroup)) {
                $this->vpwsGroup = trim($dataToProcess[0]);
            }

            $tempArray = [
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
