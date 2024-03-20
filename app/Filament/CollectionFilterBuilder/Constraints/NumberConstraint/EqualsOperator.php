<?php

namespace App\Filament\CollectionFilterBuilder\Constraints\NumberConstraint;

use App\Filament\CollectionFilterBuilder\Constraints\Operator;
use Illuminate\Support\Collection;

class EqualsOperator extends Operator
{
    /**
     * Apply a filter to a collection based on a qualified column and a number.
     *
     * @param Collection $query The collection to apply the filter to.
     * @param string $qualifiedColumn The qualified column to compare against.
     * @return Collection The filtered collection.
     */
    public function apply(Collection $query, string $qualifiedColumn) : Collection
    {
        $number = floatval($this->getSettings()['number']);

        return $query->filter(function ($item) use ($number, $qualifiedColumn) {
            $fieldVal = $this->castFieldValueToNumber($item[$qualifiedColumn]);
            $epsilon = 0.00001;
            return ($this->isInverse() ? abs($number-$fieldVal) > $epsilon : abs($number-$fieldVal) < $epsilon);
        });
    }

    /**
     * Casts the given field value to a number.
     *
     * @param mixed $fieldVal The field value to be cast.
     * @param int $precision The number of decimal places to round the result to. Default is 2.
     * @return null|float Returns the cast field value as a float if successful, or null if the field value is blank.
     */
    private function castFieldValueToNumber($fieldVal, $precision = 2) : null | float
    {
        if (blank($fieldVal)) {
            return null;
        }

        $fieldVal = preg_replace('/[^0-9.]/', '', $fieldVal);
        $fieldVal = floatval($fieldVal);

        return round($fieldVal, $precision);
    }
}
