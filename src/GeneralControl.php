<?php declare(strict_types=1);

namespace GeneralForm;

use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Localization\ITranslator;


/**
 * Class GeneralControl
 *
 * @author  geniv
 * @package GeneralForm
 */
abstract class GeneralControl extends Control implements ITemplatePath
{
    /** @var IFormContainer */
    protected $formContainer;
    /** @var IEventContainer */
    protected $eventContainer;
    /** @var ITranslator|null */
    protected $translator;
    /** @var string */
    protected $templatePath;
    /** @var callback */
    public $onSuccess, $onException;


    /**
     * GeneralControl constructor.
     *
     * @param IFormContainer   $formContainer
     * @param array            $events
     * @param ITranslator|null $translator
     */
    public function __construct(IFormContainer $formContainer, array $events, ITranslator $translator = null)
    {
        parent::__construct();

        $this->formContainer = $formContainer;
        $this->eventContainer = EventContainer::factory($this, $events);
        $this->translator = $translator;

//        $this->templatePath = __DIR__ . '/.latte';  // set path
    }


    /**
     * Set template path.
     *
     * @param string $path
     */
    public function setTemplatePath(string $path)
    {
        $this->templatePath = $path;
    }


    /**
     * Render.
     */
    public function render()
    {
        $template = $this->getTemplate();

        $template->setTranslator($this->translator);
        $template->setFile($this->templatePath);
        $template->render();
    }


    /**
     * Create component form.
     *
     * @param string $name
     * @return Form
     */
    protected function createComponentForm(string $name): Form
    {
        $form = new Form($this, $name);
        $form->setTranslator($this->translator);
        $this->formContainer->getForm($form);

        $form->onSuccess[] = $this->eventContainer;
        return $form;
    }
}
