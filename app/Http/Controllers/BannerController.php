<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponFormater;
use App\Models\Banner;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use ResponFormater;
    public function index(Request $request)
    {
      return $this->success(
        "list banner",
      Banner::paginate($request->per_page ?? config('setting.limit')),
      Response::HTTP_OK
      );
    }
}
