<?php


namespace App\Controller;

use App\Entity\MinimizeUrl;
use App\Form\Type\UrlMinimizedType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * Class MainPageController
 * @package App\Controller
 */
class MainPageController extends AbstractController
{
    const UNREAL_USER_ID = -1;

    public function index(Request $request)
    {
        $minimizeUrlRepo = $this->getDoctrine()
            ->getRepository(MinimizeUrl::class);

        $minimizeUrl = new MinimizeUrl();
        $form = $this->createForm(UrlMinimizedType::class, $minimizeUrl);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $hash = hash('crc32', $minimizeUrl->getUrl());
                $userId = $request->cookies->get('user_id');

                $minimizeUrl->setUserId($userId);
                $minimizeUrl->setHash($hash);
                $minimizeUrl->setCount(0);


                $minimizeUrlRepo->save($minimizeUrl);
            } else {
                $errors = $form->getErrors(true);
                /** @var FormError $error */
                foreach ($errors as $error) {
                    $this->addFlash('error', $error->getMessage());
                }
            }
        }

        $minimizesUrls = $minimizeUrlRepo->findBy([
            'userId' => $request->cookies->get('user_id', self::UNREAL_USER_ID),
        ]);

        $response = $this->render('home-page/index.html.twig', [
            'form' => $form->createView(),
            'minimizesUrls' => $minimizesUrls,
        ]);

        if (!$request->cookies->get('user_id')) {
            $response->headers->setCookie(
                new Cookie('user_id', rand(1, 1000000000))
            );
        }

        return $response;
    }
}
