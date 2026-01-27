<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|min:3|max:255',
            'date'        => 'required|date',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
            'task_id'     => 'nullable|exists:tasks,id',
            'assigned_to' => 'required|exists:users,id',
            'description' => 'nullable|string|max:1000',
        ];
    }
}
