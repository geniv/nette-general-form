<?php declare(strict_types=1);

use GeneralForm\IEvent;
use GeneralForm\IEventContainer;
use Nette\SmartObject;


/**
 * Class CallbackEvent
 *
 * @author  geniv
 */
class CallbackEvent implements IEvent
{
    use SmartObject;

    /** @var callable */
    public $onCallback;


    /**
     * Update.
     *
     * @param IEventContainer $eventContainer
     * @param array           $values
     */
    public function update(IEventContainer $eventContainer, array $values)
    {
        // function (IEventContainer $eventContainer, array $value)
        $this->onCallback($eventContainer, $values);
    }
}
