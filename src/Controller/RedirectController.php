<?php


namespace App\Controller;

use App\Application\RedirectPageProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class RedirectController
 * @package App\Controller
 */
class RedirectController extends AbstractController
{

    /**
     * @var RedirectPageProvider
     */
    protected $redirectPageProvider;

    /**
     * RedirectController constructor.
     * @param RedirectPageProvider $redirectPageProvider
     */
    public function __construct(
        RedirectPageProvider $redirectPageProvider
    ) {
        $this->redirectPageProvider = $redirectPageProvider;
    }

    /**
     * @param string $hash
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function index(string $hash)
    {
        $data = $this->redirectPageProvider->execute([
            'hash' => $hash,
        ]);

        return $this->redirect(
            $data['url'] ?? '/'
        );
    }
}
