<?php

namespace App\Entity;

use App\Repository\NewsArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NewsArticleRepository::class)
 */
class NewsArticle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $published_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $image_url;

    /**
     * @ORM\Column(type="text")
     */
    private string $body;

    /**
     * `id` property getter
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * `published_at` property getter
     * @return \DateTimeInterface|null
     */
    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->published_at;
    }

    /**
     * `published_at` property setter
     * @param \DateTimeInterface $published_at
     * @return $this
     */
    public function setPublishedAt(\DateTimeInterface $published_at): self
    {
        $this->published_at = $published_at;

        return $this;
    }

    /**
     * `title` property getter
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * `title` property setter
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * `image_url` property getter
     * @return string|null
     */
    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    /**
     * `image_url` property setter
     * @param string|null $image_url
     * @return $this
     */
    public function setImageUrl(?string $image_url): self
    {
        $this->image_url = $image_url;

        return $this;
    }

    /**
     * `body` property getter
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * `body` property setter
     * @param string $body
     * @return $this
     */
    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }
}
