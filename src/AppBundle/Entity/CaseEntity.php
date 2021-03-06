<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Attribute\Accessor as CaseAccessor;
use Doctrine\Common\Collections\ArrayCollection;
use Ds\Component\Locale\Model\Type\Localizable;
use Ds\Component\Model\Type\CustomIdentifiable;
use Ds\Component\Model\Type\Deletable;
use Ds\Component\Model\Type\Identifiable;
use Ds\Component\Model\Type\Uuidentifiable;
use Ds\Component\Model\Type\Ownable;
use Ds\Component\Model\Type\Identitiable;
use Ds\Component\Model\Type\Versionable;
use Ds\Component\Model\Attribute\Accessor;
use Ds\Component\Translation\Model\Attribute\Accessor as TranslationAccessor;
use Ds\Component\Translation\Model\Type\Translatable;
use Knp\DoctrineBehaviors\Model as Behavior;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\ORM\Mapping as ORM;
use Ds\Component\Locale\Model\Annotation\Locale;
use Ds\Component\Translation\Model\Annotation\Translate;
use Symfony\Bridge\Doctrine\Validator\Constraints as ORMAssert;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CaseEntity
 *
 * @ApiResource(
 *     shortName="Case",
 *     attributes={
 *         "normalization_context"={
 *             "groups"={"case_output"}
 *         },
 *         "denormalization_context"={
 *             "groups"={"case_input"}
 *         },
 *         "filters"={
 *             "app.case.search",
 *             "app.case.search_translation",
 *             "app.case.date",
 *             "app.case.order"
 *         }
 *     }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CaseRepository")
 * @ORM\Table(name="app_case")
 * @ORMAssert\UniqueEntity(fields="uuid")
 * @ORMAssert\UniqueEntity(fields="customId")
 */
class CaseEntity implements Identifiable, Uuidentifiable, CustomIdentifiable, Ownable, Translatable, Localizable, Identitiable, Deletable, Versionable
{
    use Behavior\Translatable\Translatable;
    use Behavior\Timestampable\Timestampable;
    use Behavior\SoftDeletable\SoftDeletable;

    use Accessor\Id;
    use Accessor\Uuid;
    use Accessor\CustomId;
    use Accessor\Owner;
    use Accessor\OwnerUuid;
    use Accessor\Identity;
    use Accessor\IdentityUuid;
    use TranslationAccessor\Title;
    use TranslationAccessor\Data;
    use Accessor\State;
    use Accessor\Priority;
    use CaseAccessor\Statuses;
    use Accessor\Deleted;
    use Accessor\Version;

    /**
     * @const string
     */
    const STATE_OPEN = 'open';
    const STATE_CLOSED = 'closed';

    /**
     * Returns translation entity class name
     *
     * @return string
     */
    public static function getTranslationEntityClass()
    {
        return '\AppBundle\Entity\CaseTranslation';
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
     * @var string
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"case_output"})
     * @ORM\Column(name="custom_id", type="string", length=255, unique=true)
     */
    protected $customId;

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
     * @Assert\Length(min=1, max=255)
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
     * @Assert\Length(min=1, max=255)
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
     * @Assert\All({
     *     @Assert\NotBlank,
     *     @Assert\Length(min=1)
     * })
     * @Locale
     * @Translate
     */
    protected $title;

    /**
     * @var array
     * @ApiProperty
     * @Serializer\Groups({"case_output", "case_input"})
     * @Assert\Type("array")
     * @Assert\NotBlank
     * @Assert\All({
     *     @Assert\Type("array")
     * })
     * @Locale
     * @Translate
     */
    protected $data;

    /**
     * @var string
     * @ApiProperty
     * @Serializer\Groups({"case_output", "case_input"})
     * @ORM\Column(name="state", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(min=1, max=255)
     */
    protected $state;

    /**
     * @var integer
     * @ApiProperty
     * @Serializer\Groups({"case_output", "case_input"})
     * @ORM\Column(name="priority", type="integer", options={"default":0})
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    protected $priority;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ApiProperty(writable=false)
     * @Serializer\Groups({"case_output", "case_input"})
     * @ORM\OneToMany(targetEntity="CaseStatus", mappedBy="case")
     */
    protected $statuses;

    /**
     * @var integer
     * @ApiProperty
     * @Serializer\Groups({"case_output", "case_input"})
     * @ORM\Column(name="version", type="integer")
     * @ORM\Version
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    protected $version;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->title = [];
        $this->data = [];
        $this->state = static::STATE_OPEN;
        $this->statuses = new ArrayCollection;
        $this->priority = 0;
    }
}
