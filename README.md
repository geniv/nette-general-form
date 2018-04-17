Nette general form
==================

Installation
------------
```sh
$ composer require geniv/nette-general-form
```
or
```json
"geniv/nette-general-form": ">=1.0.0"
```

require:
```json
"php": ">=7.0.0",
"nette/nette": ">=2.4.0"
```

Include in application
----------------------
usage _IEvent_:
```php
class MyEvent implements IEvent

...

public function update(IEventContainer $eventContainer, array $values)

// usage method by IEventContainer
...
$eventContainer->getForm()
$eventContainer->addValues($values)
$eventContainer->setValues($values)
$eventContainer->removeValue($key)
$eventContainer->getComponent()
$eventContainer->getEventIndex()
$eventContainer->getEvents()
```

usage _IFormContainer_ and _IEventContainer_ (can use magic `__invoke` method):
```php
private $formContainer;
private $eventContainer;
public $onSuccess, $onException;

public function __construct(IFormContainer $formContainer, array $events)

...

// $this->eventContainer = EventContainer::factory($this, $events, 'onSuccess', 'onException');
$this->eventContainer = EventContainer::factory($this, $events);
$this->formContainer = $formContainer;

...

$form->onSuccess[] = $this->eventContainer;
```
or _the old way_ without `__invoke`:
```php
try {
    $this->notify($form, $values);
    $this->onSuccess($values);
} catch (EventException $e) {
    $this->onException($e);
}
```

usage _ITemplatePath_ (without return type!):
```php
class MyForm extends Control implements ITemplatePath

...

public function setTemplatePath(string $path)
{
    $this->templatePath = $path;
}
```

Events for use (implements `IEvent`)
---------------
```neon
- DumpEvent
- FireLogEvent
- ClearFormEvent
- SetValueEvent     (setValues(array))
- CallbackEvent     (onCallback(IEventContainer, array))
- EmailNotifyEvent  (getMessage(), setTemplatePath(string))
```

### SetValueEvent
```neon
- SetValueEvent([active: false, role: guest])
```

### CallbackEvent
```neon
- CallbackEvent
```

usage in presenter:
```php
$callbackEvent->onCallback[] = function (IEventContainer $eventContainer, array $value) {
    if ($this->identityModel->existLogin($value['login'])) {
        throw new EventException('duplicate login');
    }

    if ($this->identityModel->existEmail($value['email'])) {
        throw new EventException('duplicate email');
    }
};
```

### EmailNotifyEvent
```neon
admin: Identity\Events\RegistrationEmailNotifyEvent     # email for admin
user: Identity\Events\RegistrationEmailNotifyEvent      # email for user
# or
- Identity\Events\ForgottenEmailNotifyEvent
```

where self class name (prevents multiple services in _DI_):
```php
class RegistrationEmailNotifyEvent extends EmailNotifyEvent {}
class ForgottenEmailNotifyEvent extends EmailNotifyEvent {}
```

usage in presenter:
```php
$emailNotifyEvent->onConfigure[] = function (IEventContainer $eventContainer, array $value) use ($emailNotifyEvent) {
    $emailNotifyEvent->setTemplatePath(__DIR__ . '/templates/Forgotten/emailFormForgotten.latte');

    $message = $emailNotifyEvent->getMessage();
    $message->setFrom('info@email.cz');

    $message->setSubject('informacni email pro uzivatele');
    $message->addTo($value['email']);
};

// or

$emailNotifyEvent->onConfigure[] = function (IEventContainer $eventContainer, array $value) use ($emailNotifyEvent) {
    $message = $emailNotifyEvent->getMessage();
    $message->setFrom('info@email.cz');

    switch ($eventContainer->getEventIndex()) {
        case 'user':
            $emailNotifyEvent->setTemplatePath(__DIR__ . '/templates/Registration/emailFormUser.latte');

            $message->setSubject('informacni email pro uzivatele');
            $message->addTo($value['email']);
            break;

        case 'admin':
            $emailNotifyEvent->setTemplatePath(__DIR__ . '/templates/Registration/emailFormAdmin.latte');

            $message->setSubject('informacni email pro admina');
            $message->addTo('email@email.com');
            break;
    }
};
```

event in definition is possible use several times, and define like anonymous index or text index
```neon
events:
    - DumpEvent
    - DumpEvent
    fire1: FireLogEvent
    fire2: FireLogEvent
```

Extension
---------
usage _GeneralForm_:
```php
$formContainer = GeneralForm::getDefinitionFormContainer($this);
$events = GeneralForm::getDefinitionEventContainer($this);
```

usage _GeneralControl_:
```php
class MyForm extends GeneralControl {

    public function __construct(IFormContainer $formContainer, array $events, ITranslator $translator = null)
    {
        parent::__construct($formContainer, $events, $translator);

        $this->templatePath = __DIR__ . '/MyPath.latte';    // set path
    }
}
```

Exception
---------
class: `EventException`
