<?php
namespace Discutea\DTutoBundle\Controller\Base;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Discutea\DTutoBundle\Entity\Category;
use Discutea\DTutoBundle\Controller\Base\BaseController;

/**
 * BaseCategoryController 
 * 
 * @package  DTutoBundle
 * @author   David Verdier <contact@discutea.com>
 * https://www.linkedin.com/in/verdierdavid
 *
 */
class BaseCategoryController extends BaseController
{
    /**
     * Create form for remove category
     * 
     * @param object $category Discutea\DTutoBundle\Entity\Category
     * @return object Symfony\Component\Form\Form
     * 
     */
    protected function getFormRemoverCategory(Category $category) {
        $form = $this->createFormBuilder()
            ->add('movedTo', ChoiceType::class, array(
                'choices' => $this->getAllCategories($category),
                'choices_as_values' => true,
            ))
            ->add('purge', CheckboxType::class, array(
                'label'    => 'discutea.tuto.category.removeall.label',
                'required' => false,
            ))
            ->add('save', SubmitType::class)
            ->getForm();
        
        return $form;
    }

    /**
     * 
     * Listing all tutorials order by categories
     * 
     * @param object $cat Discutea\DTutoBundle\Entity\Category
     * 
     * @return array categorie's list ordoned
     */
    private function getAllCategories(Category $cat) {
        $categories = $this->getEm()->getRepository('DTutoBundle:Category')->findBy(array(), array('position' => 'asc', ));

        $cats = array();
        foreach ($categories as $category) {
            if ($category !== $cat) {
                $cats[$category->getTitle()] = $category->getId();  
            }
        }

        return $cats;
    }
}
