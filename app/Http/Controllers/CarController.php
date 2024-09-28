<?php

namespace App\Http\Controllers;

use App\Filters\SearchByTitle;
use App\Http\Traits\ResponFormater;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Pipeline;
use Symfony\Component\HttpFoundation\Response;

class CarController extends Controller
{
  use ResponFormater;
    public function listCar(Request $request)
    {
        $cars = Car::search($request->search)
        ->paginate($request->per_page ?? config('setting.limit'));

        return $this->success("list mobil", $cars, Response::HTTP_OK);

    }

    public function listCarDropBandara(Request $request)
    {
        $cars = Car::whereRelation('leaseTypes',"lease_types.id", 1);

        $data = Pipeline::send($cars)
            ->through([
                SearchByTitle::class
            ])
            ->thenReturn()
            ->paginate($request->per_page ?? config('setting.limit'));

        return $this->success("list mobil drop bandara", $data, Response::HTTP_OK);

    }
}
