<?php


namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MinimizeUrlRepository")
 * @Orm\Table(name="minimized_urls")
 */
class MinimizeUrl
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $minimizedUrlId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $hash;

    /**
     * @var string
     * @ORM\Column
     */
    protected $url;

    /**
     * @var string
     * @ORM\Column
     */
    protected $dateExpire;

    /**
     * @var string
     * @ORM\Column
     */
    protected $userId;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $count;

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getDateExpire()
    {
        return $this->dateExpire;
    }

    /**
     * @param $dateExpire
     * @throws \Exception
     */
    public function setDateExpire($dateExpire): void
    {
        if ($dateExpire) {
            $this->dateExpire = new DateTimeExt($dateExpire->format('Y-m-d H:i:s'));
        }
    }

    /**
     * @return int
     */
    public function getMinimizedUrlId(): int
    {
        return $this->minimizedUrlId;
    }

    /**
     * @param int $minimizedUrlId
     */
    public function setMinimizedUrlId(int $minimizedUrlId): void
    {
        $this->minimizedUrlId = $minimizedUrlId;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash(string $hash): void
    {
        $this->hash = $hash;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    public function incrementPageView()
    {
        $this->count++;
    }

    /**
     * @return int
     */
    public function getDateExpireAsTimestamp() : int
    {
        return (int) strtotime(
            $this->getDateExpire()
        );
    }

    /**
     * @return bool
     */
    public function isExpired() : bool
    {
        return $this->getDateExpireAsTimestamp() < time();
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('url', new Assert\NotBlank());
        $metadata->addPropertyConstraint('url', new Assert\Url([
            'message' => 'The url "{{ value }}" is not a valid url.',
            'protocols' => ['http', 'https', 'ftp'],
        ]));

        $metadata->addPropertyConstraint('dateExpire', new Assert\NotBlank());
        $metadata->addPropertyConstraint(
            'dateExpire',
            new Assert\Type(\DateTime::class)
        );
    }
}
