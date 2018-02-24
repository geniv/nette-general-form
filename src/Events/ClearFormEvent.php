<?php declare(strict_types=1);

namespace GeneralForm;

use Nette\SmartObject;


/**
 * Class ClearFormEvent
 *
 * @author  geniv
 * @package GeneralForm
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
    public function __construct(string $snippetName)
    {
        $this->snippetName = $snippetName;
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
            $component->redrawControl($this->snippetName);
            $eventContainer->getForm()->reset();
        }
    }
}
