<?php

namespace App\Http\Traits;

trait ResponFormater
{
    public function coreReponse(string $message, $data = null, int $statusCode, bool $isSuccess = true)
    {
        if (!$message) return response()->json(['message'=> 'Pesan Wajib Di isi'], 500);


        return response()->json(
            [
                "code" => $statusCode,
                "message" => $message,
                "data" => $data
            ],
            $statusCode
        );
    }

    public function success(string $message, $data, int $statusCode = 200)
    {
        return $this->coreReponse($message,$data,$statusCode);
    }

    public function error(string $message, int $statusCode= 500, $data = null)
    {
        return $this->coreReponse($message,$data,$statusCode,false);
    }
}
