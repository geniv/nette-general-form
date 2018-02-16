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
    $this->notify($values);
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

Extension
---------
usage _GeneralForm_:
```php
$formContainer = GeneralForm::getDefinitionFormContainer($this);
$events = GeneralForm::getDefinitionEventContainer($this);
```

Exception
---------
class: `EventException`
