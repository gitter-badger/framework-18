<?php
namespace Viserio\Log\Traits;

/**
 * ProcessorTrait.
 *
 * @author  Daniel Bannert
 *
 * @since   0.9.5
 */
trait ProcessorTrait
{
    /**
     * Parse Processor.
     *
     * @param object            $handler
     * @param array|object|null $processors
     *
     * @return object
     */
    protected function parseProcessor($handler, $processors = null)
    {
        if (is_array($processors)) {
            foreach ($processors as $processor => $settings) {
                $handler->pushProcessor(new $processor($settings));
            }
        } elseif (null !== $processors) {
            $handler->pushProcessor($processors);
        }

        return $handler;
    }
}
