<?php declare(strict_types=1);

namespace GeneralForm;

use Nette\DI\CompilerExtension;
use Nette\DI\ServiceDefinition;
use Nette\DI\Statement;


/**
 * Class GeneralForm
 *
 * @author  geniv
 * @package GeneralForm
 */
class GeneralForm
{

    /**
     * Get form container definition.
     *
     * @param CompilerExtension $compilerExtension
     * @return ServiceDefinition
     */
    public static function getFormContainerDefinition(CompilerExtension $compilerExtension): ServiceDefinition
    {
        $builder = $compilerExtension->getContainerBuilder();
        $config = $compilerExtension->getConfig();

        return $builder->addDefinition($compilerExtension->prefix('form'))
            ->setFactory($config['formContainer'])
            ->setAutowired($config['autowired']);
    }


    /**
     * Get event container definition.
     *
     * @param CompilerExtension $compilerExtension
     * @return array
     */
    public static function getEventContainerDefinition(CompilerExtension $compilerExtension): array
    {
        $builder = $compilerExtension->getContainerBuilder();
        $config = $compilerExtension->getConfig();

        $events = [];
        foreach ($config['events'] as $event) {
            dump($builder->hasDefinition($event));
            if ($builder->hasDefinition($event)) {
                $events = $builder->getDefinition($event);
            } else {
                if ($event instanceof Statement) {
                    dump($event);
                }
                $events[] = $builder->addDefinition($compilerExtension->prefix(md5($event)))->setFactory($event);
            }

        }
    }
}
