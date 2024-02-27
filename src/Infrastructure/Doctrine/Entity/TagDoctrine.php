<?php

namespace App\Infrastructure\Doctrine\Entity;

use App\Infrastructure\Adapter\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
#[ORM\Table(name: 'tag')]
class TagDoctrine extends TaxonomyDoctrine
{
    #[ORM\ManyToMany(targetEntity: ArticleDoctrine::class, mappedBy: 'tags')]
    private Collection $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    /**
     * @return Collection<int, ArticleDoctrine>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(ArticleDoctrine $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setCategory($this);
        }

        return $this;
    }

    public function removeArticle(ArticleDoctrine $article): static
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategory() === $this) {
                $article->setCategory(null);
            }
        }

        return $this;
    }
}
