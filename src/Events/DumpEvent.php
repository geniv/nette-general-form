<?php declare(strict_types=1);

use GeneralForm\IEvent;
use GeneralForm\IEventContainer;
use Nette\SmartObject;


/**
 * Class DumpEven
 *
 * @author  geniv
 */
class DumpEvent implements IEvent
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
        dump($values);
    }
}
