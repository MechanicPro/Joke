<?php

namespace App\Controller;

use App\Entity\Form;
use App\Entity\Joke;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends AbstractController
{

    public function index(Request $request)
    {
        $form = new Form();
        $form->setCategories();
        $form->setEmail();

        $form = $this->createFormBuilder($form)
            ->add(
                'categories',
                ChoiceType::class,
                [
                    'choices' => $form->getCategories(),
                    'attr' => ['class' => 'custom-select mb-3'],
                    'label' => 'Категория',
                    'placeholder' => 'Выберети категорию',
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'attr' => ['class' => 'form-control'],
                    'label' => 'Email',
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Отправить и сохранить',
                    'attr' => [
                        'class' => 'btn btn-outline-success',
                        'style' => 'width:100%; margin-top: 15px',
                    ],
                ]
            )
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $joke = Joke::setJoke($data->categories);

            $file = new File();
            $file->write($data->categories, $joke);

            $mail = new Mail();
            $message = (new \Swift_Message('Случайная шутка из '.$data->categories))
                ->setFrom('ar.urbanmaf@gmail.com')
                ->setTo($data->email)
                ->setBody(
                    $this->renderView(
                        'email/mail.html.twig',
                        [
                            'theme' => $data->categories,
                            'content' => $joke,
                        ]
                    ),
                    'text/html'
                );
            $mail->SendMessage($message);

            unset($form);
            
            return $this->redirectToRoute('index');
        }

        return $this->render(
            '/form.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}