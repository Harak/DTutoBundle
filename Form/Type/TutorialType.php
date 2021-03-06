<?php
namespace Discutea\DTutoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Discutea\DTutoBundle\Form\Type\ContributionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * 
 * @package  DTutoBundle
 * @author   David Verdier <contact@discutea.com>
 * https://www.linkedin.com/in/verdierdavid
 *
 */
class TutorialType extends AbstractType
{
    /**
     *
     * @var type Symfony\Component\Security\Core\Authorization\AuthorizationChecker
     */
    protected $authorizer;

    /**
     * 
     * @param AuthorizationChecker $authorizer
     */    
    public function __construct(AuthorizationChecker $authorizer) {
        $this->authorizer = $authorizer;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'discutea.tuto.form.tuto.title'))
            ->add('description', TextType::class, array('label' => 'discutea.tuto.form.tuto.description'))
            ->add('tmpContrib', ContributionType::class, array('label' => false))
            ->add('category', EntityType::class, array(
                'label' => 'discutea.tuto.form.choice.category',
                'class' => 'DTutoBundle:Category',
                'choice_label' => 'title',
            ))
        ;

        if (true === $this->authorizer->isGranted('ROLE_MODERATOR') ) {
            $builder->add('image', UrlType::class, array(
                'label' => 'discutea.tuto.form.category.image',
                'required' => false
            ));
        } 
    }

    public function getName()
    {
        return 'DTutoBundle.tutorials';
    }
  
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Discutea\DTutoBundle\Entity\Tutorial'
        ));
    }
}
