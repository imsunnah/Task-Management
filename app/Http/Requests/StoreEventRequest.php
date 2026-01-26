<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Permission logic belongs here or in Policies
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|min:3|max:255',
            'date'        => 'required|date|after_or_equal:today',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
            'task_id'     => 'nullable|exists:tasks,id',
            'assigned_to' => 'required|exists:users,id',
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'end_time.after' => 'The event must end after it starts. Time travel is not supported yet!',
            'date.after_or_equal' => 'You cannot schedule an event in the past.',
        ];
    }
}
