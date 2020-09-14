<?php


namespace App\Controller;

use App\Entity\MinimizeUrl;
use App\Repository\MinimizeUrlRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RedirectController extends AbstractController
{
    public function index(string $hash)
    {
        /** @var MinimizeUrlRepository $minimizeUrlRepo */
        $minimizeUrlRepo = $this->getDoctrine()
            ->getRepository(MinimizeUrl::class);

        /** @var MinimizeUrl $minimizeUrl */
        $minimizeUrl = $minimizeUrlRepo->findOneBy(['hash' => $hash]);
        if (!$minimizeUrl || $minimizeUrl->isExpired()) {
            if ($minimizeUrl) {
                $minimizeUrlRepo->remove($minimizeUrl);
            }

            throw new \Exception("Not found");
        }

        $minimizeUrl->incrementPageView();
        $minimizeUrlRepo->save($minimizeUrl);

        return $this->redirect(
            $minimizeUrl->getUrl()
        );
    }
}
