api_<?= $nameLower ?>_index:
    path: /<?= $namePlural . "\n" ?>
    controller: App\Controller\Api\<?= $name ?>Controller::index
    methods: [GET]

api_<?= $nameLower ?>_create:
    path: /<?= $namePlural . "\n" ?>
    controller: App\Controller\Api\<?= $name ?>Controller::create
    methods: [POST]

api_<?= $nameLower ?>_update:
    path: /<?= $namePlural ?>/{id}
    controller: App\Controller\Api\<?= $name ?>Controller::update
    methods: [PUT]

api_<?= $nameLower ?>_delete:
    path: /<?= $namePlural ?>/{id}
    controller: App\Controller\Api\<?= $name ?>Controller::delete
    methods: [DELETE]
