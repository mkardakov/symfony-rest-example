<?php

namespace WebBundle\Controller;

use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var string
     */
    private $apiUrl;

    /**
     * DefaultController constructor.
     * @param $apiUrl
     * @param SerializerInterface $serializer
     */
    public function __construct($apiUrl, SerializerInterface $serializer)
    {
        $this->apiUrl = $apiUrl;
        $this->serializer = $serializer;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction() : Response
    {
        $goals = $this->serializer->deserialize(
            file_get_contents("{$this->apiUrl}/goal/"),
            'array',
            'json'
        );

        return $this->render('@Web/Default/index.html.twig', [
            'goals' => $goals
        ]);
    }
}
