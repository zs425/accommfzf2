<?php
namespace Travel\View\Helper;
use AceLibrary\View\Helper\AbstractViewHelper;

/**
 * @author n3ziniuka5
 * @property array                                  $options
 */
class Option extends AbstractViewHelper
{
    protected $options;

    public function __invoke($option, $category)
    {
        $arrayKey = md5($category . '_' . $option);
        if (!isset($this->options[$arrayKey])) {
            $dql   = "SELECT o.optionValue FROM Travel\Entity\Option o WHERE o.optionName = :optionName AND o.optionCategory = :optionCategory";
            $query = $this->getEntityManager()->createQuery($dql);
            $query->setParameter('optionName', $option);
            $query->setParameter('optionCategory', $category);
            $result                   = $query->getOneOrNullResult();
            $this->options[$arrayKey] = $result['optionValue'];
        }
        return $this->options[$arrayKey];
    }

}