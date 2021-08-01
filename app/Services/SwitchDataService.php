<?php

namespace App\Services;

use App\Repositories\Contracts\DatacomRepository;
use App\Repositories\Contracts\SwitchRepository;
use App\Services\Contracts\SwitchDataService as SwitchDataServiceContract;

class SwitchDataService implements SwitchDataServiceContract {
    private $datacomRepository;

    public function __construct(DatacomRepository $datacomRepository)
    {
        $this->datacomRepository = $datacomRepository;
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
        $vpwsGroup = null;
        $processedData = [];
        $switchData = $switchRepository->getData($data);
        $switchData = explode("\n", $switchData['output']);

        if (count($switchData) > 3) {
            array_splice($switchData, 0, 2);
        }

        foreach ($switchData as $item) {
            $dataToHandle = explode(" ", trim($item));

            if (is_null($vpwsGroup)) {
                $vpwsGroup = trim($dataToHandle[0]);
            }

            $tempArray = [
                'VPWS-Group' => $vpwsGroup,
                'VPN-Name' => null,
                'Status' => null,
                'Segment-1' => null,
                'State' => null,
                'Segment-2' => null,
                'Pw-ID' => null,
                'State' => null,
            ];

            foreach ($dataToHandle as $itemToHandle) {
                if ($itemToHandle === $vpwsGroup || $itemToHandle === '') {
                    continue;
                }

                $keyToFill = array_search(null, $tempArray);

                if ($keyToFill !== false) {
                    $tempArray[$keyToFill] = trim($itemToHandle);
                }
            }

            if (array_search(null, $tempArray) === false) {
                $processedData[] = $tempArray;
            }
        }

        return $processedData;
    }
}
