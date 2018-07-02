<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tag;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
     * GoalController constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
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
        $goal = $this->serializer->deserialize(
            $request->getContent(),
            \AppBundle\Entity\Tag::class,
            'json'
        );
        $this->getDoctrine()->getManager()->persist($goal);
        $this->getDoctrine()->getManager()->flush();

        return $this->handleView($this->view(null, 201));

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
    public function editAction(Request $request, Tag $goal)
    {
        $data = $this->serializer->deserialize(
            $request->getContent(),
            'array',
            'json'
        );
        $goal->merge($data);
        $this->getDoctrine()->getManager()->persist($goal);
        $this->getDoctrine()->getManager()->flush();
        return $this->handleView($this->view($goal, 200));
    }

    /**
     * @param Request $request
     * @param Tag $goal
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request, Tag $goal)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($goal);
        $em->flush();
        return $this->handleView($this->view(null, 200));
    }

}
