<?php declare(strict_types=1);

namespace App\Api\V1\Http\Requests\ShortUrl;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateShortUrlRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'url' => [
                'required',
                'active_url',
                Rule::unique('converted_urls', 'original_url')->where('user_id', auth()->id()),
            ],
        ];
    }
}
