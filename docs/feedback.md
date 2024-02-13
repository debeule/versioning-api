# Feedback

## 2024-02-13

### BPost
For future reference: one can download a list of municipalities (with postal codes and relationships) from [BPost](https://www.bpost.be/nl/postcodevalidatie-tool)

### Commands

```php
<?php

declare('strict-types=1');

namespace App\Example\Commands;

final readonly class CreateSomething
{
    public function __construct() {}

    public function __invoke() {}
}
```

#### Anatomy of a command: 
- constructor
- handle or invoke method

In commands or jobs we'd put the data we'd work with in the constructor, the dependencies are arguments for the handle or invoke method. They are injected automagically by the container.
In a listener it's slighty different, the dependencies go in the constructor and the event is injected in the handle or invoke method.

```php
<?php

namespace App\Example\Commands;

use InvalidArgumentException;

final raedonly class CreateSomething
{
    public function __construct(
        public string $name,
        public Email $email,
        public string $otherValue,
    ) {
        // here we can do optional validation that is not part of a value object
        $name !== '' or throw new InvalidArgumentException('Name can not be an empty string');
    }
    
    public function __invoke(SomethingRepository $repository, Dispatcher $events): Something
    {
        $something = Someting::fromCreateSomething($this);
        
        $respository->save($something);
        
        $events->dispatch(new SomethingWasCreated($something));
    }
}
```

### Anti-corruption layer

```php
$recordhasChanged = $school->name !== $koheraSchool->Name;
$recordhasChanged = $school->email !== $koheraSchool->School_mail;
$recordhasChanged = $school->contact_email !== $koheraSchool->Gangmaker_mail;
$recordhasChanged = $school->type !== $koheraSchool->type;
$recordhasChanged = $school->student_count !== $koheraSchool->Student_Count;
$recordhasChanged = $school->institution_id !== $koheraSchool->Instellingsnummer;
```

I strongly dislike the mixed cases as properties on the model. The table column names and model properties have a 1:1 relationship. It might be feasible to abstract this away.
Another strategy would be to ditch the models for external sources and directly query the external databases.

We could provide an interface for a query object that can be different per implementation.

```php
App\Import\Queries\ExternalSchools // interface
App\Kohera\Queries\KoheraSchools // implementation
App\Testing\Stubs\School\FakeExternalSchools // implementation
```
__note:__ this is not a distinction based on the underlying infrastructure, e.g. mysql vs memory vs sqlite. We could just as well have a query object that makes an API call.

#### Example

Let's imagine we have two data warehouses that provide us with data on schools: Kohera and Cobera.

```
Kohera School:
- ID
- Name
- type
- School_mail
- adres
- postalCode
- city
- Instellingsnummer
```
And
```
Cobera School:
- id
- name
- address_line_1
- address_line_2
- city
- postal_code
- contact
- gov_id
```

##### Interface
We could introduce an interface to abstract those differences away:
```php
interface School
{
    public function sourceId(): string; // the foreign id at the external source
    public function sourceType(): string; // the name of the external source
    public function academyId(): string;
    public function name(): string;
    public function type(): string;
    public function email(): ?string; // maybe not required?
    public function address(): Address; // another interface
}
```

##### Implementations for model or DTO

```php
<?php

declare(strict_types=1);

namespace App\Kohera;

use App\Import\School as SchoolContract;

final class School extends Model implements SchoolContract
{
    // ...
}
```

```php
<?php

declare(strict_types=1);

namespace App\Cobera;

use App\Import\School as SchoolContract;

final readonly class SchoolDTO implements SchoolContract
{
    // ...
}
```

##### Advantage
When one of the column names changes, or we need to swap values or anything, it's only done at one place:
```php
public function academyId(): string
{
    return $this->govId;
}
```
Becomes
```php
public function academyId(): string
{
    return $this->govId ?: $this->institute_number;
}
```


##### Queries
Our query implementations would return collections of the interface we defined earlier:
```php
<?php

declare(strict_types=1);

namespace App\Import\Queries;

use App\Import\School; // the interface
use App\School\Type;

interface ExternalSchools
{
    /**
     * @return array<string, School[]>
     */
    public function get(): array;
    
    public function locatedInArea(string $postalCode): self;
    
    public function ofType(Type $type): self;
}
```
Look at the SportByName query object for an immutable implementation of a query object.

## 2024-02-08

### Documentation
Update the readme.md file
- on how to get started with this project
- on how to get started with testing

### Namespaces
- Subdomains or modules inside the `app` folder are singular, not plural.
[Read more](https://softwareengineering.stackexchange.com/a/75929)
- DWH prefix in Kohera is redundant (use an alias on import in case of a collision: `use App\Kohera\School as KoheraSchool;`)

### Prefixes and suffixes
Lose all technical prefixes and suffixes, they are already part of the namespace, e.g.
```App\Sport\Commands\DoSomethingCommand``` there's twice the word command in there.

One could argue that those technical terms are not part of the ubiquitous language inside the domain and should not even be part of the namespace: we'd never discuss `DoSomethingCommand` but rather talk about `Doing Something`, e.g. `Register a user`, `extend a warranty period`, `cancel a subscription` etc.

### Dependencies

Install the following missing dev dependencies:
- `larastan/larastan` (replace `nunomaduro/larastan`)
- `brianium/paratest`

### Object namespace

This is clearly not a part of the ubiquitous language, the bounded context where the `Version` value object belongs to would rather be `Import` or so.

### Purifier object

Personally I'd prefer the term sanitizer, but this could work as well. I'd split it up in more functionality, e.g. removing whitespace could be a method and removing something else could be another method, they'd all come together in one method?

I'd move this to the Import namespace as it will be part of importing data from external sources, e.g. data warehouse, BPost (municipalities for instance), etc.

### Jobs namespace
This too, is not part of the ubiquitous language. It belongs an different namespace, probably `Import` as well.

### Commands

Make use of the command bus, this will automagically inject the dependencies. Rather than instantiating the classes yourself and manually adding the dependencies.

In your tests make use of `$this-dispatch($cmd)` (invoke method) or `$this->handle($cmd)` (handle method)

### Query objects

Learn the difference between `get` & `find`, and apply it throughout the query objects. The `get` prefixes and `query` suffixes should be dropped.

Example query object:
```php
<?php

declare(strict_types=1);

namespace App\Sports\Queries;

use App\Sports\Sport;

final class SportByName
{
    public function __construct(
        private ?FromVersion $fromVersion = null,
    ) {}

    public function query(string $name): Builder
    {
        return Sport::query()
            ->where('name', '=', $name)
            ->when($this->fromVersion, $this->fromVersion)
            ->orderBy('created_at', 'desc');
    }

    public function version(Version $version): self
    {
        return new self(new FromVersion($version));
    }

    public function get(string $name): Sport
    {
        return $this->query($name)->firstOrFail();
    }

    public function find(string $name): ?Sport
    {
        return $this->query($name)->first();
    }
}
```

### Anemic models vs Rich domain models

Look it up and add apply it to the models in this project. An object is data __and__ behaviour, add methods and/or static constructors to your models.

### Provinces

This is unlikely to change, not sure if it needs to be normalised in the database, I might prefer it as an enum in the codebase.

### Tools

Use phpstan to discover bugs statically, run the cs fixer to have a consistent style throughout the codebase.

Run both on regular intervals, they'll become part of the Github Actions anyway.

### Upserts

We discussed this but in retrospect it's useless as we'd have versioned imports, which would be a new entry each time.
