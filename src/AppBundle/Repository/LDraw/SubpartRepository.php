<?php

namespace AppBundle\Repository\LDraw;

use AppBundle\Entity\Color;
use AppBundle\Entity\LDraw\Subpart;
use AppBundle\Repository\BaseRepository;

class SubpartRepository extends BaseRepository
{
    public function findOneByKeys($parent, $child, $color)
    {
        return $this->find(['parent' => $parent, 'subpart' => $child, 'color' => $color]);
    }

    /**
     * Create new Subpart relation entity or retrieve one by foreign keys.
     *
     * @param $name
     *
     * @return Subpart
     */
    public function getOrCreate($parent, $child, $count, $colorId)
    {
        if (($subpart = $this->findOneByKeys($parent, $child, $colorId))) {
            $subpart->setCount($count);
        } else {
            $subpart = new Subpart();

            $colorRepository = $this->getEntityManager()->getRepository(Color::class);
            if(!($color = $colorRepository->find($colorId))) {
                $color = $colorRepository->find(-1);
            }

            $subpart
                ->setParent($parent)
                ->setSubpart($child)
                ->setCount($count)
                ->setColor($color);
        }

        return $subpart;
    }
}