<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Goal;
use AppBundle\Entity\Tag;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

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
        $goalDTO = $this->serializer->deserialize(
            $request->getContent(),
            \AppBundle\DTO\Goal::class,
            'json'
        );
        $errors = $this->validator->validate($goalDTO);
        if (count($errors) > 0) {
            $view = $this->view((string)$errors);
            return $this->handleView($this->view($view, 400));
        }
        $goal = new Goal();
        $goal->merge($goalDTO);
        $this->getDoctrine()->getManager()->persist($goal);
        $this->getDoctrine()->getManager()->flush();

        return $this->handleView($this->view($goal, 201));

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
        $goalDTO = $this->serializer->deserialize(
            $request->getContent(),
            \AppBundle\DTO\Goal::class,
            'json'
        );
        $errors = $this->validator->validate($goalDTO);
        if (count($errors) > 0) {
            $view = $this->view((string)$errors);
            return $this->handleView($this->view($view, 400));
        }
        $goal->merge($goalDTO);

        $this->getDoctrine()->getManager()->persist($goal);
        $this->getDoctrine()->getManager()->flush();
        return $this->handleView($this->view($goal, 200));
    }

    /**
     * @param Goal $goal
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Goal $goal)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($goal);
        $em->flush();
        return $this->handleView($this->view(null, 200));
    }

    /**
     * @param Goal $goal
     * @param int $tag_id
     * @Entity("tag", expr="repository.find(tag_id)")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addTagAction(Goal $goal, Tag $tag)
    {
        $goal->addTag($tag);
        $this->getDoctrine()->getManager()->persist($goal);
        $this->getDoctrine()->getManager()->flush();
        return $this->handleView($this->view(null, 200));
    }

    /**
     * @param Goal $goal
     * @param int $tag_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeTagAction(Goal $goal, $tag_id)
    {
        $tag = $this->getDoctrine()->getRepository(Tag::class)->find($tag_id);
        if (!$tag) {
            throw new NotFoundResourceException("Tag $tag_id does not exist");
        }
        $goal->removeTag($tag);
        $this->getDoctrine()->getManager()->persist($goal);
        $this->getDoctrine()->getManager()->flush();
        return $this->handleView($this->view(null, 200));
    }

    /**
     * @param Request $request
     * @param Goal $goal
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addCommentAction(Request $request, Goal $goal)
    {
        $commentDTO = $this->serializer->deserialize(
            $request->getContent(),
            \AppBundle\DTO\Comment::class,
            'json'
        );
        $errors = $this->validator->validate($commentDTO);
        if (count($errors) > 0) {
            $view = $this->view((string)$errors);
            return $this->handleView($this->view($view, 400));
        }
        $comment = new Comment();
        $comment->merge($commentDTO);
        $goal->addComment($comment);
        $this->getDoctrine()->getManager()->persist($comment);
        $this->getDoctrine()->getManager()->persist($goal);
        $this->getDoctrine()->getManager()->flush();
        return $this->handleView($this->view($comment, 201));
    }

    /**
     * @param Goal $goal
     * @param int $comment_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function removeCommentAction(Goal $goal, $comment_id)
    {
        $comment = $this->getDoctrine()->getRepository(Tag::class)->find($comment_id);
        if (!$comment) {
            throw new NotFoundResourceException("Tag $comment_id does not exist");
        }
        $goal->removeTag($comment);
        $this->getDoctrine()->getManager()->persist($goal);
        $this->getDoctrine()->getManager()->flush();
        return $this->handleView($this->view(null, 200));
    }
}
