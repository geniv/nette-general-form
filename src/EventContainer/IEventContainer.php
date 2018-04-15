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
     * @return mixed
     */
    public function __invoke(Form $form, array $values);


    /**
     * Get form.
     *
     * @return Form
     */
    public function getForm(): Form;


    /**
     * Set values.
     *
     * @param array $values
     */
    public function setValues(array $values);


    /**
     * Get position.
     *
     * @return int
     */
    public function getPosition(): int;


    /**
     * Get component.
     *
     * @return IComponent
     */
    public function getComponent(): IComponent;


    /**
     * Notify.
     *
     * @param Form|null  $form
     * @param array|null $values
     */
    public function notify(Form $form = null, array $values = null);
}
