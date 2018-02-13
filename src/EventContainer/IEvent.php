<?php declare(strict_types=1);

namespace GeneralForm;

/**
 * Interface IEvent
 *
 * @author  geniv
 * @package GeneralForm
 */
interface IEvent
{

    /**
     * Update.
     *
     * @param IEventContainer $eventContainer
     * @param array           $values
     */
    public function update(IEventContainer $eventContainer, array $values);
}
