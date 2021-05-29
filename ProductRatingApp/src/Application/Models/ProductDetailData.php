<?php

namespace Application\Models;

class ProductDetailData extends ProductData
{

    /**
     * ProductDetailData constructor.
     */
    public function __construct(
        int $id,
        string $producer,
        UserData $user,
        string $name,
        private array $ratings
    ) {

        $ratingSum = 0;
        $ratingCount = 0;
        if(sizeof($this->ratings) > 0) {
            foreach ($this->ratings as $rating) {
                $ratingCount++;
                $ratingSum += $rating->getRating();
            }
        }

        $ratingAverage = $ratingCount > 0 ? round($ratingSum / $ratingCount, 2) : 0;

        parent::__construct($id, $producer, $user, $name, $ratingAverage, $ratingCount);
    }

    /**
     * @return array
     */
    public function getRatings(): array
    {
        return $this->ratings;
    }


}