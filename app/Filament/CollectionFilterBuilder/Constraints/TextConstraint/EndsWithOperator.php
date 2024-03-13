<?php

namespace App\Filament\CollectionFilterBuilder\Constraints\TextConstraint;

use App\Filament\CollectionFilterBuilder\Constraints\Operator;
use Illuminate\Support\Collection;

class EndsWithOperator extends Operator
{
    public function apply(Collection $query, string $qualifiedColumn) : Collection
    {
        $text = mb_strtolower(trim($this->getSettings()['text']));

        return $query->filter(function ($item) use ($text, $qualifiedColumn) {
            return ($this->isInverse() ? !(str_ends_with(mb_strtolower(trim($item[$qualifiedColumn])), $text)) : str_ends_with(mb_strtolower(trim($item[$qualifiedColumn])), $text));
        });
    }
}
