<?php

declare(strict_types=1);

namespace App\Extensions\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope as BaseSoftDeletingScope;

final class SoftDeletingScope extends BaseSoftDeletingScope
{
    public function apply(Builder $builder, Model $model): void
    {
    }
}