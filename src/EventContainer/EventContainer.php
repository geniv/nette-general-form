<?php declare(strict_types=1);

namespace GeneralForm;

use Exception;
use Nette\ComponentModel\IComponent;


/**
 * Class EventContainer
 *
 * @author  geniv
 * @package GeneralForm
 */
class EventContainer implements IEventContainer
{
    /** @var array */
    private $events = [];
    /** @var array */
    private $values = [];
    /** @var IComponent */
    private $component;


    /**
     * EventDispatcher constructor.
     *
     * @param IComponent $component
     * @param array      $events
     */
    public function __construct(IComponent $component, array $events)
    {
        $this->component = $component;
        $this->events = $events;
    }


    /**
     * Set values.
     *
     * @param array $values
     */
    public function setValues(array $values)
    {
        $this->values = $values;
    }


    /**
     * Get component.
     *
     * @return IComponent
     */
    public function getComponent(): IComponent
    {
        return $this->component;
    }


    /**
     * Notify.
     *
     * @param null $values
     * @throws Exception
     */
    public function notify($values = null)
    {
        //if define values in parameters
        if ($values) {
            $this->setValues($values);
        }

        // iterate events
        foreach ($this->events as $event) {
            // check instance of event
            if ($event instanceof IEvent) {
                $event->update($this, $this->values);
            } else {
                throw new Exception(get_class($event) . ' is not instance of ' . IEvent::class);
            }
        }
    }
}
