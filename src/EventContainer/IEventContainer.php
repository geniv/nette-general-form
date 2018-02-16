<?php declare(strict_types=1);

namespace GeneralForm;

use Exception;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IComponent;


/**
 * Interface IEventContainer
 *
 * @author  geniv
 * @package GeneralForm
 */
interface IEventContainer
{

    /**
     * Factory.
     *
     * @param IComponent $component
     * @param array      $events
     * @param string     $callbackOnSuccess
     * @param string     $callbackOnException
     * @return IEventContainer
     */
    public static function factory(IComponent $component, array $events, $callbackOnSuccess = 'onSuccess', $callbackOnException = 'onException'): IEventContainer;


    /**
     * __invoke.
     *
     * @param Form  $form
     * @param array $values
     */
    public function __invoke(Form $form, array $values);


    /**
     * Set values.
     *
     * @param array $values
     */
    public function setValues(array $values);


    /**
     * Get component.
     *
     * @return IComponent
     */
    public function getComponent(): IComponent;


    /**
     * Notify.
     *
     * @param null $values
     * @throws Exception
     */
    public function notify($values = null);
}
