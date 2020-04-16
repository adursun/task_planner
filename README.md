# Task Planner

## Design Decisions

- Every developer should be able to work on every task
- Dynamic weekly hours should be supported

## Dependencies

- PHP 7.4.4
- Symfony 4.4
- MySQL 5.7
- Docker

## Commands

### Git

```bash
git clone git@github.com:adursun/task_planner.git
cd task_planner/
composer install
```

### Docker

```bash
# MySQL
docker pull mysql:5.7
docker run --rm --name task_planner -e MYSQL_ROOT_PASSWORD=pass -d -p 3306:3306 mysql:5.7
```

### Doctrine

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate -n
php bin/console doctrine:fixtures:load -n
```

### PHPUnit

```bash
php bin/phpunit --verbose --coverage-html coverage
```

### Task Collector

```bash
php bin/console app:collect_tasks
```

### Server

```bash
symfony server:start
```
