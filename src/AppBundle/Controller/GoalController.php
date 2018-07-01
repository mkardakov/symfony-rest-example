<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Goal;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Serializer\JMSSerializerAdapter;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GoalController
 * @package AppBundle\Controller
 */
class GoalController extends FOSRestController
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

        $goals = $em->getRepository('AppBundle:Goal')->findAll();
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
            \AppBundle\Entity\Goal::class,
            'json'
        );
        $this->getDoctrine()->getManager()->persist($goal);
        $this->getDoctrine()->getManager()->flush();

        return $this->handleView($this->view(null, 201));

    }

    /**
     * @param Goal $goal
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Goal $goal)
    {
        $view = $this->view($goal);
        return $this->handleView($view);
    }

    /**
     * @param Request $request
     * @param Goal $goal
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Goal $goal)
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
     * @param Goal $goal
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Goal $goal)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($goal);
        $em->flush();
        return $this->handleView($this->view(null, 200));
    }

}
