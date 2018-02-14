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
usage _IFormContainer_ and _IEventContainer_:
```php
public function __construct(IFormContainer $formContainer, array $events, ITranslator $translator = null)

...

$this->eventContainer = new EventContainer($this, $events);
$this->formContainer = $formContainer;

...

$form->onSuccess[] = function (Form $form, array $values) {
    try {
        $this->eventContainer->setValues($values);
        $this->eventContainer->notify();

        $this->onSuccess($values);
    } catch (ContactException $e) {
        $this->onException($e);
    }
};
```

usage _ITemplatePath_ (without return type!):
```php
class ContactForm extends Control implements ITemplatePath

...

public function setTemplatePath(string $path)
```
