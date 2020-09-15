<?php


namespace App\Application;

use App\Entity\MinimizeUrl;
use App\Repository\MinimizeUrlRepository;

/**
 * Class RedirectPageProvider
 * @package App\Application
 */
class RedirectPageProvider implements ServiceProviderInterface
{

    /**
     * @var MinimizeUrlRepository
     */
    protected $minimizeUrlRepo;

    /**
     * RedirectPageProvider constructor.
     * @param MinimizeUrlRepository $minimizeUrlRepository
     */
    public function __construct(
        MinimizeUrlRepository $minimizeUrlRepository
    ) {
        $this->minimizeUrlRepo = $minimizeUrlRepository;
    }

    /**
     * @param array $options
     * @return mixed|string
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function execute(array $options) : array
    {
        $hash = $options['hash'] ?? null;

        /** @var MinimizeUrl $minimizeUrl */
        $minimizeUrl = $this->minimizeUrlRepo
            ->findOneBy(['hash' => $hash]);

        $this->validateMinimizeUrlEntity($minimizeUrl);
        $this->setStatistic($minimizeUrl);

        return [
            'url' => $minimizeUrl->getUrl()
        ];
    }

    /**
     * @param MinimizeUrl|null $minimizeUrl
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function validateMinimizeUrlEntity(
        ?MinimizeUrl $minimizeUrl
    ) {
        if (!$minimizeUrl) {
            throw new \Exception("Not found");
        }

        if ($minimizeUrl->isExpired()) {
            $this->minimizeUrlRepo->remove($minimizeUrl);

            throw new \Exception("Not found");
        }
    }

    /**
     * @param $minimizeUrl
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function setStatistic($minimizeUrl)
    {
        $minimizeUrl->incrementPageView();
        $this->minimizeUrlRepo->save($minimizeUrl);
    }
}
