<?php declare(strict_types=1);

namespace GeneralForm;

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
     */
    public function notify();
}
