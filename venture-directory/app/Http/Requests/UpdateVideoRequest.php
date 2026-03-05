<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVideoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'required', 'string', 'min:20'],
            'youtube_url' => [
                'sometimes',
                'required',
                'url',
                'regex:/^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)[a-zA-Z0-9_-]{11}/',
            ],
            'category_id' => ['sometimes', 'required', 'exists:categories,id'],
            'entrepreneur_name' => ['sometimes', 'required', 'string', 'max:255'],
            'business_name' => ['sometimes', 'required', 'string', 'max:255'],
            'tags' => ['nullable', 'string', 'max:500'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'youtube_url.regex' => 'Please enter a valid YouTube URL.',
            'description.min' => 'Description should be at least 20 characters.',
            'category_id.exists' => 'The selected category does not exist.',
            'thumbnail.image' => 'Thumbnail must be an image file.',
            'thumbnail.max' => 'Thumbnail must be under 2MB.',
        ];
    }
}
