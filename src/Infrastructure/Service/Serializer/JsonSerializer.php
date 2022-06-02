<?php

namespace Infrastructure\Service\Serializer;

use JsonException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

class JsonSerializer
{
    /**
     * @param object $data
     * @return string
     * @throws JsonException
     */
    public function serialize(object $data): string
    {
        return $this->preparePayloadData($data);
    }

    /**
     * @throws JsonException
     */
    private function preparePayloadData(object $data): string
    {
        $stringifiesData = $this->getJsonSerializer()->serialize($data, 'json', ['json_encode_options' => JSON_INVALID_UTF8_IGNORE]);
        /** @var array<mixed> $payload */
        $payload = json_decode($stringifiesData, true, 512, JSON_THROW_ON_ERROR);

        //ensure that all string in payload are encoded to utf-8
        array_walk_recursive($payload, function (&$value) {
            if (is_string($value)) {
                $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            }
        });
        return json_encode($payload, JSON_THROW_ON_ERROR);
    }

    private function getJsonSerializer(): Serializer
    {
        return new Serializer(
            [
            new DateTimeNormalizer(),
            new PropertyNormalizer(),
            new ObjectNormalizer(),
        ],
            [
            new JsonEncoder(),
        ]
        );
    }

    public function deserialize(string $data, string $class): object
    {
        /** @var object $object */
        $object = $this->getJsonSerializer()->deserialize($data, $class, 'json');
        return $object;
    }
}
