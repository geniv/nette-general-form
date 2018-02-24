<?php declare(strict_types=1);

namespace GeneralForm;

use Nette\SmartObject;
use Tracy\Debugger;


/**
 * Class DumpEvent
 *
 * @author  geniv
 * @package GeneralForm
 */
class DumpEvent implements IEvent
{
    use SmartObject;


    /**
     * Update.
     *
     * @param IEventContainer $eventContainer
     * @param array           $values
     */
    public function update(IEventContainer $eventContainer, array $values)
    {
//        dump($values);
        Debugger::fireLog($values);
    }
}