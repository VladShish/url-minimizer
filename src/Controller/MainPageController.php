<?php


namespace App\Controller;

use App\Application\MainPageProvider;
use App\Entity\MinimizeUrl;
use App\Form\Type\UrlMinimizedType;
use App\Service\UserIdGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * Class MainPageController
 * @package App\Controller
 */
class MainPageController extends AbstractController
{

    /**
     * @var MainPageProvider
     */
    protected $mainPageProvider;

    /**
     * MainPageController constructor.
     * @param MainPageProvider $mainPageProvider
     */
    public function __construct(
        MainPageProvider $mainPageProvider
    ) {
        $this->mainPageProvider = $mainPageProvider;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $minimizeUrl = new MinimizeUrl();
        $form = $this->createForm(UrlMinimizedType::class, $minimizeUrl);
        $form->handleRequest($request);

        $data = $this->mainPageProvider->execute([
            'minimizeUrl' => $minimizeUrl,
            'form' => $form,
            'user_id' => $request->cookies->get('user_id')
        ]);

        $this->flashErrors($data['errors'] ?? []);

        $response = $this->render('home-page/index.html.twig', [
            'form' => $form->createView(),
            'minimizesUrls' => $data['minimizesUrls'] ?? [],
        ]);

        $this->setUserId($request, $response);

        return $response;
    }

    /**
     * @param array $errors
     */
    protected function flashErrors(array $errors)
    {
        foreach ($errors as $message) {
            $this->addFlash('error', $message);
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     */
    protected function setUserId(Request $request, Response $response)
    {
        if ($request->cookies->get('user_id')) {
            return;
        }

        $response->headers->setCookie(
            new Cookie('user_id', UserIdGenerator::generate())
        );
    }
}
