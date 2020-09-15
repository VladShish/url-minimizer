<?php


namespace App\Application;

use App\Entity\MinimizeUrl;
use App\Repository\MinimizeUrlRepository;
use App\Service\Minimizer;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;

/**
 * Class MainPageProvider
 * @package App\Application
 */
class MainPageProvider implements ServiceProviderInterface
{

    const UNREAL_USER_ID = -1;

    /**
     * @var MinimizeUrlRepository
     */
    protected $minimizeUrlRepo;

    /**
     * MainPageProvider constructor.
     * @param MinimizeUrlRepository $minimizeUrlRepository
     */
    public function __construct(
        MinimizeUrlRepository $minimizeUrlRepository
    ) {
        $this->minimizeUrlRepo = $minimizeUrlRepository;
    }

    /**
     * @param array $options
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function execute(array $options) : array
    {
        /** @var MinimizeUrl $minimizeUrl */
        $minimizeUrl = $options['minimizeUrl'] ?? null;
        /** @var Form $form */
        $form = $options['form'] ?? null;
        /** @var string $userId */
        $userId = $options['user_id'] ?? null;

        $minimizeUrl->setUserId($userId);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->submitLogic($minimizeUrl);
        }

        return [
            'errors' => $this->extractErrors($form),
            'minimizesUrls' => $this->minimizeUrlRepo->findByUserId(
                $userId ?? self::UNREAL_USER_ID
            ),
        ];
    }

    /**
     * @param MinimizeUrl $minimizeUrl
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function submitLogic(MinimizeUrl $minimizeUrl)
    {
        $minimizeUrl->setCount(0);
        $minimizeUrl->setHash(
            Minimizer::minimize($minimizeUrl)
        );

        if ($this->minimizeUrlRepo->isExists($minimizeUrl)) {
            return;
        }

        $this->minimizeUrlRepo->save($minimizeUrl);
    }

    /**
     * @param Form $form
     * @return array
     */
    protected function extractErrors(Form $form) : array
    {
        if (!$form->isSubmitted() || $form->isValid()) {
            return [];
        }

        $errors = $form->getErrors(true);
        $errorsMessages = [];
        /** @var FormError $error */
        foreach ($errors as $error) {
            $errorsMessages[] = $error->getMessage();
        }

        return $errorsMessages;
    }
}
