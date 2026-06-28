<?= "<?php\n" ?>

namespace App\Dto\<?= $name ?>;

use Symfony\Component\Validator\Constraints as Assert;

class Create
{
<?php foreach ($fields as $field): ?>
<?php if (!$field['nullable']): ?>
    #[Assert\NotBlank]
<?php endif; ?>
<?php if ($field['type'] === 'string' && isset($field['length'])): ?>
    #[Assert\Length(max: <?= $field['length'] ?>)]
<?php endif; ?>
    public ?<?= $field['type'] ?> $<?= $field['name'] ?> = null;

<?php endforeach; ?>
}