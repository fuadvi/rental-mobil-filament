<?php

namespace App\Http\Traits;

use Illuminate\Contracts\Validation\Validator;

trait ErrorForm
{
    use ResponFormater;
    public function failedValidation(Validator $validator)
    {
        $response = $this->error('Pengisian Form Belum Sesuai', 422, $validator->errors());

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
