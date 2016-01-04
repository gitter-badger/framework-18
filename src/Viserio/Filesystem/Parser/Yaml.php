<?php
namespace Viserio\Filesystem\Parser;

use LogicException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;
use Viserio\Contracts\Filesystem\LoadingException;
use Viserio\Contracts\Filesystem\Parser as ParserContract;
use Viserio\Filesystem\Filesystem;
use Viserio\Filesystem\Parser\Traits\IsGroupTrait;

class Yaml implements ParserContract
{
    use IsGroupTrait;

    /**
     * The filesystem instance.
     *
     * @var \Viserio\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new file filesystem loader.
     *
     * @param \Viserio\Filesystem\Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    /**
     * Loads a YAML file and gets its' contents as an array.
     *
     * @param string      $filename
     * @param string|null $group
     *
     * @throws \LogicException
     * @throws \LoadingException
     *
     * @return array|string|null
     */
    public function load($filename, $group = null)
    {
        if (!class_exists('Symfony\\Component\\Yaml\\Yaml')) {
            throw new LogicException('Loading translations from the YAML format requires the Symfony Yaml component.');
        }

        try {
            if ($this->files->exists($filename)) {
                $data = (new Parser())->parse($this->files->get($filename));

                if ($group !== null) {
                    return $this->isGroup($group, (array) $data);
                }

                return $data;
            }
        } catch (ParseException $exception) {
            throw new LoadingException(sprintf('Unable to parse the YAML string: [%s]', $exception->getMessage()));
        }
    }

    /**
     * Checking if file ist supported.
     *
     * @param string $filename
     *
     * @return bool
     */
    public function supports($filename)
    {
        return (bool) preg_match('#\.ya?ml(\.dist)?$#', $filename);
    }

    /**
     * Format a yaml file for saving.
     *
     * @param array $data data
     *
     * @return string data export
     */
    public function format(array $data)
    {
        return YamlParser::dump($data);
    }
}
