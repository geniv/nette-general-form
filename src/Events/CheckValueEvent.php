<?php declare(strict_types=1);

use GeneralForm\EventException;
use GeneralForm\IEvent;
use GeneralForm\IEventContainer;
use Identity\IIdentityModel;
use Nette\SmartObject;
use Nette\Utils\Callback;


/**
 * Class CheckValueEvent
 *
 * @author  geniv
 */
class CheckValueEvent implements IEvent
{
    use SmartObject;

    /** @var callable */
    private $callback;


    /**
     * Set callback.
     *
     * @param callable $callback
     */
    public function setCallback(callable $callback)
    {
        $this->callback = $callback;
    }


    /**
     * Update.
     *
     * @param IEventContainer $eventContainer
     * @param array           $values
     */
    public function update(IEventContainer $eventContainer, array $values)
    {
        $eventContainer->setValues(Callback::invokeSafe($this->callback, [$eventContainer, $values], null));
    }
}
