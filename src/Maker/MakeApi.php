<?php

namespace App\Maker;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

final class MakeApi extends AbstractMaker
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function configureDependencies(DependencyBuilder $dependencies)
    {
        // Rien pour l’instant
    }

    public static function getCommandName(): string
    {
        return 'make:api';
    }

    public static function getCommandDescription(): string
    {
        return 'Generate API Controller, routes YAML, Entity, Repository and DTOs';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
        $command->addArgument('name', InputArgument::REQUIRED, 'Entity name, e.g. Product');
    }

    private function mapDoctrineTypeToPhpType(string $doctrineType): string
    {
        return match ($doctrineType) {
            'string', 'text', 'guid' => 'string',
            'integer', 'smallint', 'bigint' => 'int',
            'float', 'decimal' => 'float',
            'boolean' => 'bool',
            'datetime', 'datetimetz', 'date', 'time', 'datetime_immutable', 'date_immutable' => '\DateTimeInterface',
            default => 'mixed',
        };
    }

    private function getEntityCol(string $name)
    {
        $entityClass = 'App\\Entity\\'.$name;

        $metadata = $this->entityManager->getClassMetadata($entityClass);

        $fields = [];

        foreach ($metadata->getFieldNames() as $fieldName) {
            if ('id' === $fieldName) {
                continue;
            }

            $mapping = $metadata->getFieldMapping($fieldName);

            $fields[] = [
                'name' => $fieldName,
                'type' => $this->mapDoctrineTypeToPhpType($mapping['type']),
                'nullable' => $mapping['nullable'] ?? false,
                'length' => $mapping['length'] ?? null,
            ];
        }

        return $fields;
    }

    public function generate(
        InputInterface $input,
        ConsoleStyle $io,
        Generator $generator,
    ): void {
        $name = ucfirst($input->getArgument('name'));
        $nameLower = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));
        $namePlural = $nameLower.'s';
        $fields = $this->getEntityCol($name);

        $vars = [
            'name' => $name,
            'nameLower' => $nameLower,
            'namePlural' => $namePlural,
            'fields' => $fields,
        ];

        $base = \dirname(__DIR__, 2);

        $generator->generateFile(
            "src/Controller/Api/{$name}Controller.php",
            $base.'/templates/maker/api/controller.tpl.php',
            $vars
        );

        $generator->generateFile(
            "src/Dto/{$name}/Create{$name}Dto.php",
            $base.'/templates/maker/api/create_dto.tpl.php',
            $vars
        );

        $generator->generateFile(
            "src/Dto/{$name}/Update{$name}Dto.php",
            $base.'/templates/maker/api/update_dto.tpl.php',
            $vars
        );

        $generator->generateFile(
            "config/routes/api/{$nameLower}.yaml",
            $base.'/templates/maker/api/routes.yaml.tpl.php',
            $vars
        );

        $generator->writeChanges();
    }
}
