<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponFormater;
use App\Models\Tour;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TourController extends Controller
{
  use ResponFormater;

    public function index(Request $request)
    {
      $tours = Tour::search($request->search)->paginate($request->per_page ?? config('setting.limit'));

      return $this->success("list paket wisata", $tours, Response::HTTP_OK);
    }

  public function show($slug)
  {
    $tour = Tour::with('cars:id,title,image')->whereSlug($slug)->firstOrFail();

    return $this->success("list paket wisata", $tour, Response::HTTP_OK);
  }
}
