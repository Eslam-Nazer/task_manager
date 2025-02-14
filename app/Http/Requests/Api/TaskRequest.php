<?php

namespace App\Http\Requests\Api;

use App\Enum\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'status' => ['required', Rule::in($status)],
        ];
    }
}
