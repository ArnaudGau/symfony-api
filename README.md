# Symfony API

Projet Symfony genere avec `symfony/skeleton` en version 8.1.

## Demarrage

```bash
make build
make up
```

L'application est disponible sur `http://localhost:8080`.

## Commandes Makefile

Le projet se pilote principalement avec `make`. Les commandes executent Docker Compose et lancent les actions dans le conteneur `app`.

Certaines commandes prennent une variable :

- `cmd` : commande Symfony ou Composer a passer.
- `name` : nom d'une ressource, entite ou controller a generer.

Exemples :

```bash
make console cmd="debug:router"
make composer cmd="require symfony/orm-pack"
make resource name=Product
```

### Docker

| Commande | Description |
| --- | --- |
| `make build` | Construit les images Docker et installe les dependances Composer avec `composer install`. |
| `make up` | Demarre les conteneurs en arriere-plan. |
| `make down` | Arrete et supprime les conteneurs. |
| `make restart` | Redemarre les conteneurs avec `make down` puis `make up`. |
| `make serve` | Demarre Docker Compose au premier plan. Utile pour voir les logs en direct. |
| `make logs` | Affiche les logs du conteneur `app` en continu. |
| `make shell` | Ouvre un shell Bash dans le conteneur `app`. |

### Composer et Console Symfony

| Commande | Description |
| --- | --- |
| `make install` | Installe les dependances Composer dans le conteneur. |
| `make update` | Met a jour les dependances Composer. |
| `make composer cmd="..."` | Execute une commande Composer dans le conteneur `app`. |
| `make console cmd="..."` | Execute une commande Symfony `bin/console` dans le conteneur `app`. |
| `make cache-clear` | Vide le cache Symfony. |
| `make cache-warmup` | Rechauffe le cache Symfony. |

### Symfony et Doctrine

| Commande | Description |
| --- | --- |
| `make entity` | Lance l'assistant Symfony `make:entity`. |
| `make controller` | Lance l'assistant Symfony `make:controller`. |
| `make api name=Name` | Genere un controller Symfony sans template avec le nom fourni. |
| `make resource name=Name` | Genere une entite Doctrine puis les fichiers API associes via `make:api`. |
| `make migration` | Genere une migration Doctrine. |
| `make migrate` | Execute les migrations Doctrine sans interaction. |
| `make rollback` | Revient a la migration Doctrine precedente. |
| `make schema-validate` | Verifie que le mapping Doctrine est coherent avec la base de donnees. |
| `make fixtures` | Recharge les fixtures Doctrine sans interaction. |
| `make fixture` | Ajoute les fixtures Doctrine sans vider la base grace a l'option `--append`. |

### Generation d'une ressource API

La commande `make resource name=Name` genere une ressource API a partir du nom fourni. Remplacer `Name` par le nom souhaite, par exemple `Languages`, `Product` ou `Category`.

```bash
make resource name=Name
```

Exemple :

```bash
make resource name=Languages
```

La commande execute d'abord `make:entity Name` pour creer ou modifier l'entite Doctrine, puis `make:api Name` pour generer les fichiers API associes :

- `src/Controller/Api/NameController.php`
- `src/Dto/Name/Create.php`
- `src/Dto/Name/Edit.php`
- `config/routes/api/name.yaml`

Apres la generation, il reste des choses a ajouter manuellement.

Dans le repository, ajouter les methodes attendues par `BaseCrudController`, notamment `create()` et `update()`. Exemple avec une ressource `Languages` :

```php
public function create(Create $dto): Languages
{
    $language = new Languages();
    $language->setName($dto->name);
    $language->setCode($dto->code);

    $this->getEntityManager()->persist($language);
    $this->getEntityManager()->flush();

    return $language;
}

public function update(Languages $language, Edit $dto): Languages
{
    if (null !== $dto->name) {
        $language->setName($dto->name);
    }

    if (null !== $dto->code) {
        $language->setCode($dto->code);
    }

    $this->getEntityManager()->flush();

    return $language;
}
```

Dans l'entite, ajouter les groupes de serialization sur les champs a retourner dans l'API :

```php
use Symfony\Component\Serializer\Attribute\Groups;

#[Groups(['languages:read'])]
private ?int $id = null;

#[Groups(['languages:read'])]
private ?string $name = null;

#[Groups(['languages:read'])]
private ?string $code = null;
```

Le nom du groupe doit correspondre a celui retourne par le controller genere dans `getReadGroups()`.

Dans route.yml, ajouter les accès au nouveau fichier de route :
```php
languages:
    prefix: /api
    resource: 'routes/languages.yaml'
```

### Base de donnees

| Commande | Description |
| --- | --- |
| `make reset-db` | Supprime la base si elle existe, la recree, lance les migrations puis charge les fixtures. |

### Debug

| Commande | Description |
| --- | --- |
| `make routes` | Affiche toutes les routes Symfony. |
| `make debug-env` | Affiche les variables d'environnement connues par le conteneur Symfony. |

### Tests et qualite

| Commande | Description |
| --- | --- |
| `make test` | Lance PHPUnit via `bin/phpunit`. |
| `make tests` | Lance les tests avec Symfony PHPUnit Bridge. |
| `make pint` | Verifie le formatage du code avec Pint en mode test. |
| `make pint-c` | Corrige le formatage du code avec Pint. |
| `make pint-v` | Verifie le formatage avec Pint en mode verbeux. |

## Exemples utiles

```bash
make routes
make cache-clear
make migrate
make fixture
make resource name=Languages
```
