<?php

namespace App\Http\Requests\Api\V1;

use App\Repositories\TeamRepository;
use Illuminate\Foundation\Http\FormRequest;

class AddTeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(TeamRepository $teamRepository)
    {
        return [
            'name' => [
                'required',
                function($attribute, $value, $fail) use($teamRepository){
                    // check for duplicate slug
                    if($teamRepository->checkDuplicateSlugAvailable($value)){
                        $fail($value.' is already available');
                    }

                    // todo
                    // check for total available entry is not more than 8

                }
            ]
        ];
    }
}
