# Rector Rules for `moneyphp/money`

## Install

```bash
composer require codito/rector-money --dev
```

## Use Sets

To add a set to your config, use `Codito\Rector\Money\MoneySetList` class:

```php
use Rector\Configuration\Option;
use Codito\Rector\Money\MoneySetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(MoneySetList::V4);
};
```

## Contributing

If you want to contribute to this package just clone this repository:

- make all changes to achieve what you need
- run `make qa` and ensure everything passes
- create Pull Request

Thanks in advance! :beers:

## Development environment

For developing this package you should use prepared Docker stack. All commands should be executed
through `docker-compose`:

```
docker-compose run php composer install
```

or using `make` wrapper:

```
make run cmd="composer install"
```

### Debugging with XDebug

XDebug is installed in PHP container and Docker stack is pre-configured to use it, but by default it's in `off` mode. If
you need to debug code just set `XDEBUG_MODE=debug` in `.env` file and enable listening for connections in IDE.
