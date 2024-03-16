<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', \Symfony\Component\Form\Extension\Core\Type\FileType::class, [
                'label' => 'File with Transactions',
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => ['application/json'],
                    ])
                ],
            ])
            ->add('send', SubmitType::class)
        ;
    }
}