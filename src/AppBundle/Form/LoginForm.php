<?php
/**
 * Created by PhpStorm.
 * User: Кирилл
 * Date: 26.04.2018
 * Time: 12:33
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginForm extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('_username', TextType::class, ['attr' => ['placeholder' => 'Электронная почта']])
            ->add('_password', PasswordType::class, ['attr' => ['placeholder' => 'Пароль']]);
    }


}