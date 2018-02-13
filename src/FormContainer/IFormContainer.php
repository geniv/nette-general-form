<?php declare(strict_types=1);

namespace GeneralForm;

use Nette\Application\UI\Form;


/**
 * Interface IFormContainer
 *
 * @author  geniv
 * @package GeneralForm
 */
interface IFormContainer
{

    /**
     * Get form.
     *
     * @param Form $form
     */
    public function getForm(Form $form);
}
