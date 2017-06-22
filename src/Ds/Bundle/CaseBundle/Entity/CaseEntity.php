<?php

namespace Ds\Bundle\CaseBundle\Entity;

use Ds\Component\Model\Type\Identifiable;
use Ds\Component\Model\Type\Uuidentifiable;
use Ds\Component\Model\Type\Translatable;
use Ds\Component\Model\Type\Ownable;
use Ds\Component\Model\Type\Identitiable;
use Ds\Component\Model\Attribute\Accessor;
use Knp\DoctrineBehaviors\Model as Behavior;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Ds\Component\Model\Annotation\Translate;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as ORMAssert;

/**
 * Class CaseEntity
 *
 * @ApiResource(
 *      shortName="Case",
 *      attributes={
 *          "filters"={"ds_case.filter.case"},
 *          "normalization_context"={"groups"={"case_output"}},
 *          "denormalization_context"={"groups"={"case_input"}}
 *      }
 * )
 * @ORM\Entity(repositoryClass="Ds\Bundle\CaseBundle\Repository\CaseRepository")
 * @ORM\Table(name="ds_case")
 * @ORM\HasLifecycleCallbacks
 * @ORMAssert\UniqueEntity(fields="uuid")
 */
class CaseEntity implements Identifiable, Uuidentifiable, Ownable, Translatable, Identitiable
{
    use Behavior\Translatable\Translatable;
    use Behavior\Timestampable\Timestampable;
    use Behavior\SoftDeletable\SoftDeletable;

    use Accessor\Id;
    use Accessor\Uuid;
    use Accessor\Owner;
    use Accessor\OwnerUuid;
    use Accessor\Identity;
    use Accessor\IdentityUuid;
    use Accessor\Translation\Title;
    use Accessor\Translation\Presentation;

    /**
     * Returns translation entity class name
     *
     * @return string
     */
    public static function getTranslationEntityClass()
    {
        return '\Ds\Bundle\CaseBundle\Entity\CaseTranslation';
    }

    /**
     * @var integer
     * @ApiProperty(identifier=false, writable=false)
     * @Serializer\Groups({"case_output"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @var string
     * @ApiProperty(identifier=true, writable=false)
     * @Serializer\Groups({"case_output"})
     * @ORM\Column(name="uuid", type="guid", unique=true)
     * @Assert\Uuid
     */
    protected $uuid;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"case_output"})
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"case_output"})
     */
    protected $updatedAt;

    /**
     * @var \DateTime
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"case_output"})
     */
    protected $deletedAt;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"case_output", "case_input"})
     * @ORM\Column(name="`owner`", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    protected $owner;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"case_output", "case_input"})
     * @ORM\Column(name="owner_uuid", type="guid", nullable=true)
     * @Assert\NotBlank
     * @Assert\Uuid
     */
    protected $ownerUuid;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"case_output", "case_input"})
     * @ORM\Column(name="identity", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    protected $identity;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"case_output", "case_input"})
     * @ORM\Column(name="identity_uuid", type="guid", nullable=true)
     * @Assert\NotBlank
     * @Assert\Uuid
     */
    protected $identityUuid;

    /**
     * @var array
     * @ApiProperty
     * @Serializer\Groups({"case_output", "case_input"})
     * @Assert\Type("array")
     * @Assert\NotBlank
     * @Translate
     */
    protected $title;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->title = [];
    }
}
