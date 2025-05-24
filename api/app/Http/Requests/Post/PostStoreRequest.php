<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('user')?->is($this->user());
    }

    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:280'],
        ];
    }
}
