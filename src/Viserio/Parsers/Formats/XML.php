<?php
namespace Viserio\Parsers\Formats;

use DOMException;
use Exception;
use RuntimeException;
use Spatie\ArrayToXml\ArrayToXml;
use Viserio\Contracts\Parsers\Exception\DumpException;
use Viserio\Contracts\Parsers\Exception\ParseException;
use Viserio\Contracts\Parsers\Format as FormatContract;

class XML implements FormatContract
{
    /**
     * {@inheritdoc}
     */
    public function parse(string $payload): array
    {
        try {
            $data = simplexml_load_string($payload, 'SimpleXMLElement', LIBXML_NOCDATA);
            $data = json_decode(json_encode((array) $data), true); // Work around to accept xml input
            $data = str_replace(':{}', ':null', $data);
            $data = str_replace(':[]', ':null', $data);

            return $data;
        } catch (Exception $exception) {
            throw new ParseException([
                'message' => 'Failed To Parse XML',
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function dump(array $data): string
    {
        if (! class_exists('Spatie\\ArrayToXml\\ArrayToXml')) {
            throw new RuntimeException('Unable to dump XML, the ArrayToXml dumper is not installed.');
        }

        try {
            return ArrayToXml::convert($data);
        } catch (DOMException $exception) {
            throw new DumpException($exception->getMessage());
        }
    }
}
