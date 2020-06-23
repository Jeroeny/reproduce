# reproduce

### Install

```
composer install
```

### Usage

Run the command that makes a request using `Psr\Http\Client\ClientInterface`:
```bash
./bin/console -vvv run:psr18
```

Which outputs:
```bash
07:59:05 ERROR     [console] Error thrown while running command "-vvv run:psr18". Message: "Unable to seek to stream position 0 with whence 0"
[
  "exception" => RuntimeException {
    #message: "Unable to seek to stream position 0 with whence 0"
    #code: 0
    #file: "\reproduce\vendor\guzzlehttp\psr7\src\Stream.php"
    #line: 204
    trace: {
      \reproduce\vendor\guzzlehttp\psr7\src\Stream.php:204 { …}
      \reproduce\vendor\symfony\http-client\Psr18Client.php:111 { …}
      \reproduce\src\Command\PsrClientCommand.php:29 {
        App\Command\PsrClientCommand->execute(InputInterface $input, OutputInterface $output): int
        ›     'GET',\r
        ›     'https://raw.githubusercontent.com/symfony/symfony/master/.gitignore')\r
        › );\r
        arguments: {
          $request: GuzzleHttp\Psr7\Request { …}
        }
      }
      \reproduce\vendor\symfony\console\Command\Command.php:258 { …}
      \reproduce\vendor\symfony\console\Application.php:929 { …}
      \reproduce\vendor\symfony\framework-bundle\Console\Application.php:96 { …}
      \reproduce\vendor\symfony\console\Application.php:264 { …}
      \reproduce\vendor\symfony\framework-bundle\Console\Application.php:82 { …}
      \reproduce\vendor\symfony\console\Application.php:140 { …}
      \reproduce\bin\console:43 { …}
    }
  },
  "command" => "-vvv run:psr18",
  "message" => "Unable to seek to stream position 0 with whence 0"
]
07:59:05 DEBUG     [console] Command "-vvv run:psr18" exited with code "1"
[
  "command" => "-vvv run:psr18",
  "code" => 1
]

In Stream.php line 204:
                                                     
  [RuntimeException]                                 
  Unable to seek to stream position 0 with whence 0  

Exception trace:
  at \reproduce\vendor\guzzlehttp\psr7\src\Stream.php:204
 GuzzleHttp\Psr7\Stream->seek() at \reproduce\vendor\symfony\http-client\Psr18Client.php:111
 Symfony\Component\HttpClient\Psr18Client->sendRequest() at \reproduce\src\Command\PsrClientCommand.php:29
 App\Command\PsrClientCommand->execute() at \reproduce\vendor\symfony\console\Command\Command.php:258
 Symfony\Component\Console\Command\Command->run() at \reproduce\vendor\symfony\console\Application.php:929
 Symfony\Component\Console\Application->doRunCommand() at \reproduce\vendor\symfony\framework-bundle\Console\Application.php:96
 Symfony\Bundle\FrameworkBundle\Console\Application->doRunCommand() at \reproduce\vendor\symfony\console\Application.php:264
 Symfony\Component\Console\Application->doRun() at \reproduce\vendor\symfony\framework-bundle\Console\Application.php:82
 Symfony\Bundle\FrameworkBundle\Console\Application->doRun() at \reproduce\vendor\symfony\console\Application.php:140
 Symfony\Component\Console\Application->run() at \reproduce\bin\console:43

run:psr18 [-h|--help] [-q|--quiet] [-v|vv|vvv|--verbose] [-V|--version] [--ansi] [--no-ansi] [-n|--no-interaction] [-e|--env ENV] [--no-debug] [--] <command>
```

Run the command that makes a request using `\Symfony\Contracts\HttpClient\HttpClientInterface`:
```bash
./bin/console -vvv run:symfony
```

### Debug

The bug does not appear when `symfony/http-client": "5.0.*"` is set (to `5.0.*`).

Interface `Psr\Http\Client\ClientInterface` is implemented by ` Symfony\Component\HttpClient\Psr18Client`:

```bash
./bin/console -vvv debug:container Psr\Http\Client\ClientInterface

 // This service is a private alias for the service psr18.http_client

Information for Service "psr18.http_client"
===========================================

 An adapter to turn a Symfony HttpClientInterface into a PSR-18 ClientInterface.

 ---------------- ------------------------------------------
  Option           Value                                    
 ---------------- ------------------------------------------
  Service ID       psr18.http_client
  Class            Symfony\Component\HttpClient\Psr18Client
  Tags             -
  Public           no
  Synthetic        no
  Lazy             no
  Shared           yes
  Abstract         no
  Autowired        no
  Autoconfigured   no
 ---------------- ------------------------------------------


 ! [NOTE] The "Psr\Http\Client\ClientInterface" service or alias has been removed or inlined when the container was     
 !        compiled.                                                                                                     

```

Run without framework works:

```bash
php ./run.php
```
