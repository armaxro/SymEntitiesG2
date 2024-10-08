<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(
        options: [
            'unsigned' => true,]
)]
    private ?int $id = null;

    #[ORM\Column(length: 160)]
    private ?string $postTitle = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $postText = null;

    #[ORM\Column(
        type: Types::DATETIME_MUTABLE,
        #valeur par default, false 0
        options: [
        'default' => 'CURRENT_TIMESTAMP',
        ]
    )]
    private ?\DateTimeInterface $postDateCreated = null;

    #[ORM\Column(
        type: Types::DATETIME_MUTABLE,
        nullable: true
    )]
    private ?\DateTimeInterface $postDatePublished = null;

    #[ORM\Column(
        options: [
            'default' => false,
        ]
    )]
    private ?bool $postPublished = null;

    /**
     * @var Collection<int, Section>
     */
    #[ORM\ManyToMany(targetEntity: Section::class, mappedBy: 'sectionPost')]
    private Collection $sections;

    public function __construct()
    {
        $this->sections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostTitle(): ?string
    {
        return $this->postTitle;
    }

    public function setPostTitle(string $postTitle): static
    {
        $this->postTitle = $postTitle;

        return $this;
    }

    public function getPostText(): ?string
    {
        return $this->postText;
    }

    public function setPostText(string $postText): static
    {
        $this->postText = $postText;

        return $this;
    }

    public function getPostDateCreated(): ?\DateTimeInterface
    {
        return $this->postDateCreated;
    }

    public function setPostDateCreated(?\DateTimeInterface $postDateCreated): static
    {
        $this->postDateCreated = $postDateCreated;

        return $this;
    }

    public function getPostDatePublished(): ?\DateTimeInterface
    {
        return $this->postDatePublished;
    }

    public function setPostDatePublished(?\DateTimeInterface $postDatePublished): static
    {
        $this->postDatePublished = $postDatePublished;

        return $this;
    }

    public function isPostPublished(): ?bool
    {
        return $this->postPublished;
    }

    public function setPostPublished(?bool $postPublished): static
    {
        $this->postPublished = $postPublished;

        return $this;
    }

    /**
     * @return Collection<int, Section>
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(Section $section): static
    {
        if (!$this->sections->contains($section)) {
            $this->sections->add($section);
            $section->addSectionPost($this);
        }

        return $this;
    }

    public function removeSection(Section $section): static
    {
        if ($this->sections->removeElement($section)) {
            $section->removeSectionPost($this);
        }

        return $this;
    }
}
