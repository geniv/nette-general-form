<?php declare(strict_types=1);

namespace GeneralForm;

use Nette\Application\UI\Form;
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
    /** @var string */
    private $callbackOnSuccess, $callbackOnException;


    /**
     * EventContainer constructor.
     *
     * @param IComponent $component
     * @param array      $events
     */
    private function __construct(IComponent $component, array $events)
    {
        $this->component = $component;
        $this->events = $events;
    }


    /**
     * Set callback onSuccess.
     *
     * @param mixed $callbackOnSuccess
     */
    public function setCallbackOnSuccess($callbackOnSuccess)
    {
        $this->callbackOnSuccess = $callbackOnSuccess;
    }


    /**
     * Set callback onException.
     *
     * @param mixed $callbackOnException
     */
    public function setCallbackOnException($callbackOnException)
    {
        $this->callbackOnException = $callbackOnException;
    }


    /**
     * Factory.
     *
     * @param IComponent $component
     * @param array      $events
     * @param string     $callbackOnSuccess
     * @param string     $callbackOnException
     * @return IEventContainer
     */
    public static function factory(IComponent $component, array $events, $callbackOnSuccess = 'onSuccess', $callbackOnException = 'onException'): IEventContainer
    {
        $instance = new self($component, $events);
        $instance->setCallbackOnSuccess($callbackOnSuccess);
        $instance->setCallbackOnException($callbackOnException);
        return $instance;
    }


    /**
     * __invoke.
     *
     * @param Form  $form
     * @param array $values
     */
    public function __invoke(Form $form, array $values)
    {
        try {
            $this->notify($values);

            if (property_exists($this->getComponent(), $this->callbackOnSuccess)) {
                $this->getComponent()->{$this->callbackOnSuccess}($values);
            }
        } catch (EventException $e) {
            if (property_exists($this->getComponent(), $this->callbackOnException)) {
                $this->getComponent()->{$this->callbackOnException}($e);
            }
        }
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
     * @throws EventException
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
                throw new EventException(get_class($event) . ' is not implements of ' . IEvent::class);
            }
        }
    }
}
