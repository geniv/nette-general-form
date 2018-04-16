<?php declare(strict_types=1);

use GeneralForm\EventException;
use GeneralForm\IEvent;
use GeneralForm\IEventContainer;
use GeneralForm\ITemplatePath;
use Nette\Application\UI\ITemplateFactory;
use Nette\Localization\ITranslator;
use Nette\Mail\IMailer;
use Nette\Mail\Message;
use Nette\Mail\SendException;
use Nette\SmartObject;


/**
 * Class EmailNotifyEvent
 *
 * @author  geniv
 */
class EmailNotifyEvent implements IEvent, ITemplatePath
{
    use SmartObject;

    /** @var ITemplateFactory */
    private $templateFactory;
    /** @var ITranslator */
    private $translator;
    /** @var IMailer */
    private $mailer;
    /** @var Message */
    private $message;
    /** @var string */
    private $templatePath;
    /** @var callable */
    public $onConfigure;


    /**
     * EmailNotifyEvent constructor.
     *
     * @param ITemplateFactory $templateFactory
     * @param ITranslator|null $translator
     * @param IMailer          $mailer
     */
    public function __construct(ITemplateFactory $templateFactory, ITranslator $translator = null, IMailer $mailer)
    {
        $this->templateFactory = $templateFactory;
        $this->translator = $translator;
        $this->mailer = $mailer;

        $this->message = new Message;

        $this->templatePath = __DIR__ . '/EmailNotifyEvent.latte';  // set path
    }


    /**
     * Get message.
     *
     * @return Message
     */
    public function getMessage(): Message
    {
        return $this->message;
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
     * Update.
     *
     * @param IEventContainer $eventContainer
     * @param array           $values
     * @throws EventException
     */
    public function update(IEventContainer $eventContainer, array $values)
    {
        // manual clean for add method with append
        $this->message->setHeader('Reply-To', null);
        $this->message->setHeader('To', null);
        $this->message->setHeader('Cc', null);
        $this->message->setHeader('Bcc', null);

        if ($this->onConfigure) {
            // if callback define
            $this->onConfigure($eventContainer, $values);
        }

        // latte
        $template = $this->templateFactory->createTemplate()
            ->setTranslator($this->translator)
            ->setFile($this->templatePath);

        $template->values = $values;

        // html message
        $this->message->setHtmlBody($template);

        try {
            $this->mailer->send($this->message);
        } catch (SendException $e) {
            throw new EventException($e->getMessage());
        }
    }
}
