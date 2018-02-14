<?php declare(strict_types=1);

namespace GeneralForm;

/**
 * Interface ITemplatePath
 *
 * @author  geniv
 * @package GeneralForm
 */
interface ITemplatePath
{

    /**
     * Set template path.
     *
     * @param string $path
     */
    public function setTemplatePath(string $path): self;
}
