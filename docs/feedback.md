# Feedback

2024-02-08

## Documentation
Update the readme.md file
- on how to get started with this project
- on how to get started with testing

## Namespaces
- Subdomains or modules inside the `app` folder are singular, not plural.
[Read more](https://softwareengineering.stackexchange.com/a/75929)
- DWH prefix in Kohera is redundant (use an alias on import in case of a collision: `use App\Kohera\School as KoheraSchool;`)

## Prefixes and suffixes
Lose all technical prefixes and suffixes, they are already part of the namespace, e.g.
```App\Sport\Commands\DoSomethingCommand``` there's twice the word command in there.

One could argue that those technical terms are not part of the ubiquitous language inside the domain and should not even be part of the namespace: we'd never discuss `DoSomethingCommand` but rather talk about `Doing Something`, e.g. `Register a user`, `extend a warranty period`, `cancel a subscription` etc.

## Dependencies

Install the following missing dev dependencies:
- `larastan/larastan` (replace `nunomaduro/larastan`)
- `brianium/paratest`

## Object namespace

This is clearly not a part of the ubiquitous language, the bounded context where the `Version` value object belongs to would rather be `Import` or so.

## Purifier object

Personally I'd prefer the term sanitizer, but this could work as well. I'd split it up in more functionality, e.g. removing whitespace could be a method and removing something else could be another method, they'd all come together in one method?

I'd move this to the Import namespace as it will be part of importing data from external sources, e.g. data warehouse, BPost (municipalities for instance), etc.

## Jobs namespace
This too, is not part of the ubiquitous language. It belongs an different namespace, probably `Import` as well.

## Commands

Make use of the command bus, this will automagically inject the dependencies. Rather than instantiating the classes yourself and manually adding the dependencies.

In your tests make use of `$this-dispatch($cmd)` (invoke method) or `$this->handle($cmd)` (handle method)

## Query objects

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

## Anemic models vs Rich domain models

Look it up and add apply it to the models in this project. An object is data __and__ behaviour, add methods and/or static constructors to your models.

## Provinces

This is unlikely to change, not sure if it needs to be normalised in the database, I might prefer it as an enum in the codebase.

## Tools

Use phpstan to discover bugs statically, run the cs fixer to have a consistent style throughout the codebase.

Run both on regular intervals, they'll become part of the Github Actions anyway.

## Upserts

We discussed this but in retrospect it's useless as we'd have versioned imports, which would be a new entry each time.
