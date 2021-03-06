<?php declare(strict_types=1);

use GeneralForm\IEvent;
use GeneralForm\IEventContainer;
use Nette\SmartObject;


/**
 * Class ClearFormEvent
 *
 * @author  geniv
 */
class ClearFormEvent implements IEvent
{
    use SmartObject;

    // define constant name
    const
        SNIPPET_NAME = 'wrapper';

    /** @var string */
    private $snippetName;


    /**
     * ClearFormEvent constructor.
     *
     * @param string $snippetName
     */
    public function __construct(string $snippetName = '')
    {
        $this->snippetName = $snippetName ?: self::SNIPPET_NAME;
    }


    /**
     * Update.
     *
     * @param IEventContainer $eventContainer
     * @param array           $values
     */
    public function update(IEventContainer $eventContainer, array $values)
    {
        $component = $eventContainer->getComponent();
        if ($component->presenter->isAjax()) {
            // ajax reset form
            $component->redrawControl($this->snippetName);
            $eventContainer->getForm()->reset();
        } else {
            // non ajax fallback
            $eventContainer->getForm()->reset();
        }
    }
}
