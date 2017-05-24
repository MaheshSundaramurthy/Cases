<?php

namespace Ds\Bundle\CaseBundle\DataFixtures\ORM;

use Ds\Bundle\CaseBundle\Entity\CaseEntity;
use Ds\Component\Migration\Fixture\ORM\ResourceFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadCaseData
 */
class LoadCaseData extends ResourceFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $fixtures = $this->parse(__DIR__.'/../../Resources/data/{server}/cases.yml');

        foreach ($fixtures as $fixture) {
            $entity = new CaseEntity();
            $entity->setUuid($fixture['uuid']);
            $entity->setOwner($fixture['owner']);
            $entity->setOwnerUuid($fixture['ownerUuid']);
            $entity->setIdentity($fixture['identity']);
            $entity->setIdentityUuid($fixture['identityUuid']);
            $entity->setTitle($fixture['title']);

            $manager->persist($entity);
            $manager->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 0;
    }
}
