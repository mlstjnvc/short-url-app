<?php declare(strict_types=1);

namespace App\Api\V1\Services\ShortUrl;

use App\Api\V1\Exceptions\ShortUrl\CreateShortUrlException;
use Throwable;

class CreateShortUrlService
{
    const SHORT_URL_LENGTH = 7;

    const SHORT_URL_ROUTE_PREFIX = 'short-url/';

    /**
     * @param array $data
     * @return mixed
     * @throws CreateShortUrlException
     */
    public function execute(array $data)
    {
        try {
            $shortUrl = substr(bin2hex(openssl_random_pseudo_bytes(10)), 0, self::SHORT_URL_LENGTH);

            $user = auth()->user();

            $user->convertedUrls()->create([
                'original_url' => $data['url'],
                'short_url' => $shortUrl,
            ]);

            return env('APP_URL') . self::SHORT_URL_ROUTE_PREFIX . $shortUrl;
        } catch (Throwable $t) {
            throw new CreateShortUrlException('Unable to create short url.', 5000, $t);
        }
    }

}
