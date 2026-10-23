<?php

namespace App\Http\Requests;

use App\Models\Quote;
use Illuminate\Foundation\Http\FormRequest;

class UpdateQuoteRequest extends FormRequest
{
    // Errors go to the "update" bag so only the edited card shows them
    protected $errorBag = 'update';

    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('quote')) ?? false;
    }

    public function rules(): array
    {
        return [
            'text' => ['required', 'string', 'min:3', 'max:155'],
            'mood' => ['required', 'in:' . implode(',', array_keys(Quote::MOODS))],
        ];
    }
}