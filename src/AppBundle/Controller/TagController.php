<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tag;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Tag controller.
 *
 */
class TagController extends FOSRestController
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * GoalController constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * Lists all goal entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $goals = $em->getRepository('AppBundle:Tag')->findAll();
        $view = $this->view($goals);
        return $this->handleView($view);
    }

    /**
     * Creates a new goal entity.
     *
     */
    public function newAction(Request $request)
    {
        $tagDTO = $this->serializer->deserialize(
            $request->getContent(),
            \AppBundle\DTO\Tag::class,
            'json'
        );
        $errors = $this->validator->validate($tagDTO);
        if (count($errors) > 0) {
            $view = $this->view((string)$errors);
            return $this->handleView($this->view($view, 400));
        }
        $tag = new Tag();
        $tag->merge($tagDTO);
        $this->getDoctrine()->getManager()->persist($tag);
        $this->getDoctrine()->getManager()->flush();

        return $this->handleView($this->view($tag, 201));

    }

    /**
     * @param Tag $goal
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Tag $goal)
    {
        $view = $this->view($goal);
        return $this->handleView($view);
    }

    /**
     * @param Request $request
     * @param Tag $goal
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Tag $tag)
    {
        $tagDTO = $this->serializer->deserialize(
            $request->getContent(),
            \AppBundle\DTO\Tag::class,
            'json'
        );
        $errors = $this->validator->validate($tagDTO);
        if (count($errors) > 0) {
            $view = $this->view((string)$errors);
            return $this->handleView($this->view($view, 400));
        }
        $tag->merge($tagDTO);
        $this->getDoctrine()->getManager()->persist($tag);
        $this->getDoctrine()->getManager()->flush();
        return $this->handleView($this->view($tag, 200));
    }

    /**
     * @param Request $request
     * @param Tag $tag
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request, Tag $tag)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($tag);
        $em->flush();
        return $this->handleView($this->view(null, 200));
    }

}
