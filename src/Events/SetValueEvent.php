<?php declare(strict_types=1);

use GeneralForm\IEvent;
use GeneralForm\IEventContainer;
use Nette\SmartObject;


/**
 * Class SetValueEvent
 *
 * @author  geniv
 */
class SetValueEvent implements IEvent
{
    use SmartObject;

    /** @var array */
    private $values;


    /**
     * SetValueEvent constructor.
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }


    /**
     * Update.
     *
     * @param IEventContainer $eventContainer
     * @param array           $values
     */
    public function update(IEventContainer $eventContainer, array $values)
    {
        $eventContainer->setValues($this->values + $values);
    }
}
