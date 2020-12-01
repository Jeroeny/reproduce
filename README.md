# reproduce

GitHub issue: https://github.com/symfony/symfony/issues/39265

Bug: A yaml config file containing escaped quotes throws an error in `5.1.9` (but not in `5.1.8`) and in `5.2.0`.

In this reproducer, the `5.1.8` contains a new symfony project with symfony components locked to `5.1.8`. `5.2.0` has the same but for that version. It contains one added class in `src/` and a piece of config to reproduce the bug: 
So the `5.1.8` project will **not** throw an exception when running `bin/console`, but `5.2.0` will.

```yaml
    App\Example:
        arguments:
            $foo: 'bla\'
```

```bash
.\5.2.0\bin\console -vvv

In FileLoader.php line 173:
                                                                                                                                                                                                                                                                                                                       
  [Symfony\Component\Config\Exception\LoaderLoadException]                                                                                                                                                                                                                                                             
  The file "\reproduce\5.2.0\src\../config/services.yaml" does not contain valid YAML: Malformed inline YAML string at line 37 in \reproduce\5.2.0\src\../config/services.yaml (which is being imported from "C:\Users\speej\Develo  
  p\github.com\Jeroeny\reproduce\5.2.0\src\Kernel.php").                                                                                                                                                                                                                                                               
                                                                                                                                                                                                                                                                                                                       

Exception trace:
  at \reproduce\5.2.0\vendor\symfony\config\Loader\FileLoader.php:173
 Symfony\Component\Config\Loader\FileLoader->doImport() at \reproduce\5.2.0\vendor\symfony\config\Loader\FileLoader.php:97
 Symfony\Component\Config\Loader\FileLoader->import() at \reproduce\5.2.0\vendor\symfony\dependency-injection\Loader\FileLoader.php:64
 Symfony\Component\DependencyInjection\Loader\FileLoader->import() at \reproduce\5.2.0\vendor\symfony\dependency-injection\Loader\Configurator\ContainerConfigurator.php:61
 Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator->import() at \reproduce\5.2.0\src\Kernel.php:20
 App\Kernel->configureContainer() at \reproduce\5.2.0\vendor\symfony\framework-bundle\Kernel\MicroKernelTrait.php:155
 App\Kernel->Symfony\Bundle\FrameworkBundle\Kernel\{closure}() at \reproduce\5.2.0\vendor\symfony\dependency-injection\Loader\ClosureLoader.php:38
 Symfony\Component\DependencyInjection\Loader\ClosureLoader->load() at \reproduce\5.2.0\vendor\symfony\config\Loader\DelegatingLoader.php:40
 Symfony\Component\Config\Loader\DelegatingLoader->load() at \reproduce\5.2.0\vendor\symfony\framework-bundle\Kernel\MicroKernelTrait.php:163
 App\Kernel->registerContainerConfiguration() at \reproduce\5.2.0\vendor\symfony\http-kernel\Kernel.php:644
 Symfony\Component\HttpKernel\Kernel->buildContainer() at \reproduce\5.2.0\vendor\symfony\http-kernel\Kernel.php:540
 Symfony\Component\HttpKernel\Kernel->initializeContainer() at \reproduce\5.2.0\vendor\symfony\http-kernel\Kernel.php:780
 Symfony\Component\HttpKernel\Kernel->preBoot() at \reproduce\5.2.0\vendor\symfony\http-kernel\Kernel.php:121
 Symfony\Component\HttpKernel\Kernel->boot() at \reproduce\5.2.0\vendor\symfony\framework-bundle\Console\Application.php:168
 Symfony\Bundle\FrameworkBundle\Console\Application->registerCommands() at \reproduce\5.2.0\vendor\symfony\framework-bundle\Console\Application.php:74
 Symfony\Bundle\FrameworkBundle\Console\Application->doRun() at \reproduce\5.2.0\vendor\symfony\console\Application.php:166
 Symfony\Component\Console\Application->run() at \reproduce\5.2.0\bin\console:43

In YamlFileLoader.php line 745:
                                                                                                                                                                         
  [Symfony\Component\DependencyInjection\Exception\InvalidArgumentException]                                                                                             
  The file "\reproduce\5.2.0\src\../config/services.yaml" does not contain valid YAML: Malformed inline YAML string at line 37  
                                                                                                                                                                         

Exception trace:
  at \reproduce\5.2.0\vendor\symfony\dependency-injection\Loader\YamlFileLoader.php:745
 Symfony\Component\DependencyInjection\Loader\YamlFileLoader->loadFile() at \reproduce\5.2.0\vendor\symfony\dependency-injection\Loader\YamlFileLoader.php:123
 Symfony\Component\DependencyInjection\Loader\YamlFileLoader->load() at \reproduce\5.2.0\vendor\symfony\config\Loader\FileLoader.php:158
 Symfony\Component\Config\Loader\FileLoader->doImport() at \reproduce\5.2.0\vendor\symfony\config\Loader\FileLoader.php:97
 Symfony\Component\Config\Loader\FileLoader->import() at \reproduce\5.2.0\vendor\symfony\dependency-injection\Loader\FileLoader.php:64
 Symfony\Component\DependencyInjection\Loader\FileLoader->import() at \reproduce\5.2.0\vendor\symfony\dependency-injection\Loader\Configurator\ContainerConfigurator.php:61
 Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator->import() at \reproduce\5.2.0\src\Kernel.php:20
 App\Kernel->configureContainer() at \reproduce\5.2.0\vendor\symfony\framework-bundle\Kernel\MicroKernelTrait.php:155
 App\Kernel->Symfony\Bundle\FrameworkBundle\Kernel\{closure}() at \reproduce\5.2.0\vendor\symfony\dependency-injection\Loader\ClosureLoader.php:38
 Symfony\Component\DependencyInjection\Loader\ClosureLoader->load() at \reproduce\5.2.0\vendor\symfony\config\Loader\DelegatingLoader.php:40
 Symfony\Component\Config\Loader\DelegatingLoader->load() at \reproduce\5.2.0\vendor\symfony\framework-bundle\Kernel\MicroKernelTrait.php:163
 App\Kernel->registerContainerConfiguration() at \reproduce\5.2.0\vendor\symfony\http-kernel\Kernel.php:644
 Symfony\Component\HttpKernel\Kernel->buildContainer() at \reproduce\5.2.0\vendor\symfony\http-kernel\Kernel.php:540
 Symfony\Component\HttpKernel\Kernel->initializeContainer() at \reproduce\5.2.0\vendor\symfony\http-kernel\Kernel.php:780
 Symfony\Component\HttpKernel\Kernel->preBoot() at \reproduce\5.2.0\vendor\symfony\http-kernel\Kernel.php:121
 Symfony\Component\HttpKernel\Kernel->boot() at \reproduce\5.2.0\vendor\symfony\framework-bundle\Console\Application.php:168
 Symfony\Bundle\FrameworkBundle\Console\Application->registerCommands() at \reproduce\5.2.0\vendor\symfony\framework-bundle\Console\Application.php:74
 Symfony\Bundle\FrameworkBundle\Console\Application->doRun() at \reproduce\5.2.0\vendor\symfony\console\Application.php:166
 Symfony\Component\Console\Application->run() at \reproduce\5.2.0\bin\console:43

In Parser.php line 1216:
                                                     
  [Symfony\Component\Yaml\Exception\ParseException]  
  Malformed inline YAML string at line 37            
                                                     

Exception trace:
  at \reproduce\5.2.0\vendor\symfony\yaml\Parser.php:1216
 Symfony\Component\Yaml\Parser->lexInlineQuotedString() at \reproduce\5.2.0\vendor\symfony\yaml\Parser.php:765
 Symfony\Component\Yaml\Parser->parseValue() at \reproduce\5.2.0\vendor\symfony\yaml\Parser.php:342
 Symfony\Component\Yaml\Parser->doParse() at \reproduce\5.2.0\vendor\symfony\yaml\Parser.php:525
 Symfony\Component\Yaml\Parser->parseBlock() at \reproduce\5.2.0\vendor\symfony\yaml\Parser.php:320
 Symfony\Component\Yaml\Parser->doParse() at \reproduce\5.2.0\vendor\symfony\yaml\Parser.php:525
 Symfony\Component\Yaml\Parser->parseBlock() at \reproduce\5.2.0\vendor\symfony\yaml\Parser.php:320
 Symfony\Component\Yaml\Parser->doParse() at \reproduce\5.2.0\vendor\symfony\yaml\Parser.php:525
 Symfony\Component\Yaml\Parser->parseBlock() at \reproduce\5.2.0\vendor\symfony\yaml\Parser.php:320
 Symfony\Component\Yaml\Parser->doParse() at \reproduce\5.2.0\vendor\symfony\yaml\Parser.php:96
 Symfony\Component\Yaml\Parser->parse() at \reproduce\5.2.0\vendor\symfony\yaml\Parser.php:64
 Symfony\Component\Yaml\Parser->parseFile() at \reproduce\5.2.0\vendor\symfony\dependency-injection\Loader\YamlFileLoader.php:743
 Symfony\Component\DependencyInjection\Loader\YamlFileLoader->loadFile() at \reproduce\5.2.0\vendor\symfony\dependency-injection\Loader\YamlFileLoader.php:123
 Symfony\Component\DependencyInjection\Loader\YamlFileLoader->load() at \reproduce\5.2.0\vendor\symfony\config\Loader\FileLoader.php:158
 Symfony\Component\Config\Loader\FileLoader->doImport() at \reproduce\5.2.0\vendor\symfony\config\Loader\FileLoader.php:97
 Symfony\Component\Config\Loader\FileLoader->import() at \reproduce\5.2.0\vendor\symfony\dependency-injection\Loader\FileLoader.php:64
 Symfony\Component\DependencyInjection\Loader\FileLoader->import() at \reproduce\5.2.0\vendor\symfony\dependency-injection\Loader\Configurator\ContainerConfigurator.php:61
 Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator->import() at \reproduce\5.2.0\src\Kernel.php:20
 App\Kernel->configureContainer() at \reproduce\5.2.0\vendor\symfony\framework-bundle\Kernel\MicroKernelTrait.php:155
 App\Kernel->Symfony\Bundle\FrameworkBundle\Kernel\{closure}() at \reproduce\5.2.0\vendor\symfony\dependency-injection\Loader\ClosureLoader.php:38
 Symfony\Component\DependencyInjection\Loader\ClosureLoader->load() at \reproduce\5.2.0\vendor\symfony\config\Loader\DelegatingLoader.php:40
 Symfony\Component\Config\Loader\DelegatingLoader->load() at \reproduce\5.2.0\vendor\symfony\framework-bundle\Kernel\MicroKernelTrait.php:163
 App\Kernel->registerContainerConfiguration() at \reproduce\5.2.0\vendor\symfony\http-kernel\Kernel.php:644
 Symfony\Component\HttpKernel\Kernel->buildContainer() at \reproduce\5.2.0\vendor\symfony\http-kernel\Kernel.php:540
 Symfony\Component\HttpKernel\Kernel->initializeContainer() at \reproduce\5.2.0\vendor\symfony\http-kernel\Kernel.php:780
 Symfony\Component\HttpKernel\Kernel->preBoot() at \reproduce\5.2.0\vendor\symfony\http-kernel\Kernel.php:121
 Symfony\Component\HttpKernel\Kernel->boot() at \reproduce\5.2.0\vendor\symfony\framework-bundle\Console\Application.php:168
 Symfony\Bundle\FrameworkBundle\Console\Application->registerCommands() at \reproduce\5.2.0\vendor\symfony\framework-bundle\Console\Application.php:74
 Symfony\Bundle\FrameworkBundle\Console\Application->doRun() at \reproduce\5.2.0\vendor\symfony\console\Application.php:166
 Symfony\Component\Console\Application->run() at \reproduce\5.2.0\bin\console:43

```

No exception with `5.1.8`:

```bash
 .\5.1.8\bin\console -vvv

Symfony 5.1.8 (env: dev, debug: true)

...
```
