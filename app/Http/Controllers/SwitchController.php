<?php

namespace App\Http\Controllers;

use App\Services\Contracts\SwitchDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Ssh\Ssh;

class SwitchController extends Controller
{
    private $swtichDataService;

    public function __construct(SwitchDataService $switchDataService)
    {
        $this->swtichDataService = $switchDataService;
    }

    public function show($switchBrand, Request $request)
    {
        $dataToReturn = $this->swtichDataService->getData($switchBrand, $request->input());
        $statusCode = 200;

        if (!$dataToReturn) {
            $dataToReturn = [
                'error' => 'Something went wrong! :('
            ];
            $statusCode = 500;
        }

        return response()->json($dataToReturn, $statusCode);
    }
}
