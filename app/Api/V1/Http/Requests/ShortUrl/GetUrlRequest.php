<?php declare(strict_types=1);

namespace App\Api\V1\Http\Requests\ShortUrl;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetUrlRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'short_url' => [
                'required',
                'string',
                Rule::exists('converted_urls', 'short_url')->where('user_id', auth()->id()),
            ],
        ];
    }
}
