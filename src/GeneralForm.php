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
     * Get definition form container.
     *
     * @param CompilerExtension $compilerExtension
     * @param string            $prefixName
     * @param string            $indexConfig
     * @return ServiceDefinition
     */
    public static function getDefinitionFormContainer(CompilerExtension $compilerExtension, $indexConfig = 'formContainer', $prefixName = 'form'): ServiceDefinition
    {
        $builder = $compilerExtension->getContainerBuilder();
        $config = $compilerExtension->getConfig();

        return $builder->addDefinition($compilerExtension->prefix($prefixName))
            ->setFactory($config[$indexConfig])
            ->setAutowired($config['autowired']);
    }


    /**
     * Get definition event container.
     *
     * @param CompilerExtension $compilerExtension
     * @param string            $indexConfig
     * @return array
     */
    public static function getDefinitionEventContainer(CompilerExtension $compilerExtension, $indexConfig = 'events'): array
    {
        $builder = $compilerExtension->getContainerBuilder();
        $config = $compilerExtension->getConfig();

        $events = [];
        foreach ($config[$indexConfig] as $event) {
            // get name from event/statement
            $name = $event;
            if ($event instanceof Statement) {
                $name = $event->getEntity();
            }

            // get part name
            $exp = explode('\\', $name);
            if (count($exp) > 1) {
                $name = $exp[count($exp) - 1];  // get last index
            }

            $events[] = $builder->addDefinition($compilerExtension->prefix($name))
                ->setFactory($event)
                ->setAutowired($config['autowired']);
        }
        return $events;
    }
}
