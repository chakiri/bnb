<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{
    /**
     *Return tab labels and placeholders
     */
    private function getConfiguration($label, $placeholder)
    {
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',
                TextType::class,
                $this->getConfiguration('Titre', 'Entrez Titre ...')
            )
            ->add('coverImage',
                UrlType::class,
                $this->getConfiguration('URL de l\'image principale', 'Entrez l\'url de l\'image ...')
            )
            ->add('price',
                MoneyType::class,
                $this->getConfiguration('Prix par nuit', 'Entrez Le prix par nuit...')
            )
            ->add('rooms',
                IntegerType::class,
                $this->getConfiguration('Chambres', 'Indiquez le nombre de chambres')
            )
            ->add('introduction',
                TextType::class,
                $this->getConfiguration('Introduction', 'Entrez l\'introduction ...')
            )
            ->add('content',
                TextareaType::class,
                $this->getConfiguration('Contenu',
                    'Entrez le contenu ...')
            )
            ->add('images',
                CollectionType::class, [
                    'entry_type' => ImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false       #force symfony à appeler les méthodes add et remove et ainsi set automatiquement l'entitté mére ($image->setAd($ad))
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
