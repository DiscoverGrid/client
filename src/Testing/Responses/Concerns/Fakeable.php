<?php

declare(strict_types=1);

namespace OpenAI\Testing\Responses\Concerns;

use OpenAI\Responses\ResponseMetaInformation;

trait Fakeable
{
    /**
     * @param  array<string, mixed>  $override
     */
    public static function fake(array $override = [], ResponseMetaInformation $meta = null): static
    {
        $class = str_replace('Responses\\', 'Testing\\Responses\\Fixtures\\', static::class).'Fixture';

        return static::from(
            self::buildAttributes($class::ATTRIBUTES, $override),
            $meta ?? self::fakeResponseMetaInformation(),
        );
    }

    /**
     * @return mixed[]
     */
    private static function buildAttributes(array $original, array $override): array
    {
        $new = [];

        foreach ($original as $key => $entry) {
            $new[$key] = is_array($entry) ?
                self::buildAttributes($entry, $override[$key] ?? []) :
                $override[$key] ?? $entry;
        }

        return $new;
    }

    public static function fakeResponseMetaInformation(): ResponseMetaInformation
    {
        return ResponseMetaInformation::from([
            'openai-model' => 'text-davinci-003',
            'openai-organization' => 'org-1234',
            'openai-processing-ms' => '410',
            'openai-version' => '2020-10-01',
            'x-ratelimit-limit-requests' => '3000',
            'x-ratelimit-limit-tokens' => '250000',
            'x-ratelimit-remaining-requests' => '2999',
            'x-ratelimit-remaining-tokens' => '249989',
            'x-ratelimit-reset-requests' => '20ms',
            'x-ratelimit-reset-tokens' => '2ms',
            'x-request-id' => '3813fa4fa3f17bdf0d7654f0f49ebab4',
        ]);
    }
}
