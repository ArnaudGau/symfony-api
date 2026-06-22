// templates/maker/api/create_dto.tpl.php
<?= "<?php\n" ?>

namespace App\Dto\<?= $name ?>;

final class Create<?= $name ?>Dto
{
    public function __construct(
        <?php foreach ($fields as $field): ?>
            public <?= $field['nullable'] ? '?' : '' ?><?= $field['type'] ?> $<?= $field['name'] ?>,
        <?php endforeach; ?>
        ) {
    }
}