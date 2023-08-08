<?php 

namespace App\EntityListener;

use App\Entity\Article;
use Doctrine\ORM\Events;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;


#[AsEntityListener(event: Events::prePersist, entity: Article::class)]
#[AsEntityListener(event: Events::preUpdate, entity: Article::class)]
class ArticleEntityListener 
{
    private $slugger;
    
    public function __construct(SluggerInterface $slugger, Security $security){
        $this->slugger = $slugger;
        $this->security = $security;
    }

    public function prePersist(Article $article, LifecycleEventArgs $event) : void 
    {
        $article->computeSlug($this->slugger);
        $article->setUser($this->security->getUser());
    }

    public function preUpdate(Article $article, LifecycleEventArgs $event ) :void
    {
        $article->computeSlug($this->slugger);
    }
}





?>