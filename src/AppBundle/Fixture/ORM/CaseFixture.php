<?php

namespace AppBundle\Fixture\ORM;

use AppBundle\Entity\CaseEntity;
use Doctrine\Common\Persistence\ObjectManager;
use Ds\Component\Database\Fixture\ORM\ResourceFixture;

/**
 * Class CaseFixture
 */
abstract class CaseFixture extends ResourceFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $items = $this->parse($this->getResource());

        foreach ($items as $item) {
            $case = new CaseEntity;
            $case
                ->setUuid($item['uuid'])
                ->setOwner($item['owner'])
                ->setOwnerUuid($item['owner_uuid'])
                ->setOwner($item['identity'])
                ->setOwnerUuid($item['identity_uuid'])
                ->setTitle($item['title']);
            $manager->persist($case);
            $manager->flush();
        }
    }

    /**
     * Get resource
     *
     * @return string
     */
    abstract protected function getResource();
}
