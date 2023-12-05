<?php

namespace App\Service;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

class LoadPostsService
{

    public function __construct(
        private HttpClientInterface $client,
        private EntityManagerInterface $em,
    ) {
    }

    public function loadPosts()
    {
        $qb = $this->em->getRepository(Post::class)->createQueryBuilder('p');
        if ($qb->select('count(p)')->getQuery()->getSingleScalarResult()) {
            return 'Posts already loaded';
        }
        try {
            $posts = $this->getPosts();
            $users = $this->getUsers();
            foreach ($posts as $post) {
                $postEntity = new Post();
                $postEntity->setName($users[$post['userId']]['name']);
                $postEntity->setSurName($users[$post['userId']]['username']);
                $this->em->persist($postEntity);
            }
            $this->em->flush();
            return 'Posts loaded';
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function getPosts()
    {
        $resp = $this->client->request(
            'GET',
            'https://jsonplaceholder.typicode.com/posts'
        );
        return $resp->toArray();
    }

    public function getUsers()
    {
        $resp = $this->client->request(
            'GET',
            'https://jsonplaceholder.typicode.com/users'
        );
        $content = $resp->toArray();
        $contentKeyIsId = [];
        foreach ($content as $value) {
            $contentKeyIsId[$value['id']] = $value;
        }
        return $contentKeyIsId;
    }
}
