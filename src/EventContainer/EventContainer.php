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
    /** @var Form */
    private $form;
    /** @var array */
    private $values = [];
    /** @var int */
    private $position;
    /** @var IComponent */
    private $component;
    /** @var string */
    private $callbackOnSuccess, $callbackOnException;


    /**
     * EventContainer constructor.
     *
     * @param IComponent $component
     * @param array      $events
     * @param string     $callbackOnSuccess
     * @param string     $callbackOnException
     */
    private function __construct(IComponent $component, array $events, string $callbackOnSuccess, string $callbackOnException)
    {
        $this->component = $component;
        $this->events = $events;

        $this->callbackOnSuccess = $callbackOnSuccess;
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
        $instance = new self($component, $events, $callbackOnSuccess, $callbackOnException);
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
            $this->notify($form, $values);

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
     * Get form.
     *
     * @return Form
     */
    public function getForm(): Form
    {
        return $this->form;
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
     * Get position.
     *
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
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
     * @param Form|null  $form
     * @param array|null $values
     * @throws EventException
     */
    public function notify(Form $form = null, array $values = null)
    {
        //if define form in parameters
        if ($form) {
            $this->form = $form;
        }

        //if define values in parameters
        if ($values) {
            $this->setValues($values);
        }

        // iterate events
        foreach ($this->events as $position => $event) {
            // save position event
            $this->position = $position;

            // check instance of event
            if ($event instanceof IEvent) {
                $event->update($this, $this->values);
            } else {
                throw new EventException(get_class($event) . ' is not implements of ' . IEvent::class);
            }
        }
    }
}
