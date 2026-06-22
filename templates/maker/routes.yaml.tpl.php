api_<?= $nameLower ?>_index:
    path: /api/<?= $namePlural ?>
    controller: App\Controller\Api\<?= $name ?>Controller::index
    methods: [GET]

api_<?= $nameLower ?>_show:
    path: /api/<?= $namePlural ?>/{id}
    controller: App\Controller\Api\<?= $name ?>Controller::show
    methods: [GET]

api_<?= $nameLower ?>_create:
    path: /api/<?= $namePlural ?>
    controller: App\Controller\Api\<?= $name ?>Controller::create
    methods: [POST]

api_<?= $nameLower ?>_update:
    path: /api/<?= $namePlural ?>/{id}
    controller: App\Controller\Api\<?= $name ?>Controller::update
    methods: [PUT]

api_<?= $nameLower ?>_delete:
    path: /api/<?= $namePlural ?>/{id}
    controller: App\Controller\Api\<?= $name ?>Controller::delete
    methods: [DELETE]