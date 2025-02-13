<?php

namespace App\Http\Requests\Task;

use App\Enum\StatusEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $status = StatusEnum::values();

        return [
            'title'     => ['required', 'string', 'min:3', 'max:255'],
            'status'    => ['required', 'string', Rule::in($status)],
        ];
    }
}
