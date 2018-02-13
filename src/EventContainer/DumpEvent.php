<?php declare(strict_types=1);

namespace GeneralForm;

/**
 * Class DumpEvent
 *
 * @author  geniv
 * @package GeneralForm
 */
class DumpEvent implements IEvent
{

    /**
     * Update.
     *
     * @param IEventContainer $eventContainer
     * @param array           $values
     */
    public function update(IEventContainer $eventContainer, array $values)
    {
        dump($values);
    }
}
