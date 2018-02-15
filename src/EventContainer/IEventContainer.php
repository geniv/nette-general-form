<?php declare(strict_types=1);

namespace GeneralForm;

use Exception;
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
     *
     * @param null $values
     * @throws Exception
     */
    public function notify($values = null);
}
