<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:20'],
            'youtube_url' => [
                'required',
                'url',
                'regex:/^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)[a-zA-Z0-9_-]{11}/',
            ],
            'category_id' => ['required', 'exists:categories,id'],
            'entrepreneur_name' => ['required', 'string', 'max:255'],
            'business_name' => ['required', 'string', 'max:255'],
            'tags' => ['nullable', 'string', 'max:500'],
            'thumbnail' => ['nullable', 'image', 'max:2048'], // 2MB max
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Every video needs a title.',
            'description.required' => 'Please describe the entrepreneurial journey.',
            'description.min' => 'Description should be at least 20 characters.',
            'youtube_url.required' => 'A YouTube URL is required.',
            'youtube_url.regex' => 'Please enter a valid YouTube URL.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category does not exist.',
            'entrepreneur_name.required' => 'Who is the entrepreneur featured?',
            'business_name.required' => 'What is the business name?',
            'thumbnail.image' => 'Thumbnail must be an image file.',
            'thumbnail.max' => 'Thumbnail must be under 2MB.',
        ];
    }
}
