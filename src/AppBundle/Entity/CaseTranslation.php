<?php

namespace AppBundle\Entity;

use Ds\Component\Model\Attribute\Accessor;
use Knp\DoctrineBehaviors\Model as Behavior;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class CaseTranslation
 *
 * @ORM\Entity
 * @ORM\Table(name="app_case_trans")
 */
class CaseTranslation
{
    use Behavior\Translatable\Translation;

    use Accessor\Title;
    use Accessor\Data;

    /**
     * Returns the translatable entity class name.
     *
     * @return string
     */
    public static function getTranslatableEntityClass()
    {
        return 'AppBundle\Entity\CaseEntity';
    }

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(name="data", type="json_array")
     */
    protected $data;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->data = [];
    }
}
