<?php declare(strict_types=1);

use GeneralForm\IEvent;
use GeneralForm\IEventContainer;
use Nette\SmartObject;
use Tracy\Debugger;


/**
 * Class FireLogEvent
 *
 * @author  geniv
 */
class FireLogEvent implements IEvent
{
    use SmartObject;


    /**
     * Update.
     *
     * @param IEventContainer $eventContainer
     * @param array           $values
     */
    public function update(IEventContainer $eventContainer, array $values)
    {
        Debugger::fireLog($values);
    }
}
