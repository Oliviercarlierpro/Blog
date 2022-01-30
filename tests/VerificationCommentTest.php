<?php

namespace App\Tests;

use App\Service\VerificationComment;
use PHPUnit\Framework\TestCase;
use App\Entity\Comment;

class VerificationCommentTest extends TestCase
{
protected $comment;

    protected function setUp(): void
    {
       $this->comment = new Comment();
    }
    
    public function testContientMotInterdit()
    {
        $service = new VerificationComment();

        $this->comment->setComment('Ceci est un commentaire mauvais ');

        $result = $service->CommentaireNonAutorise( $this->comment );

        $this->assertTrue($result);
    }
    public function testNeContientPasMotInterdit(){

        $service = new VerificationComment();


        $this->comment ->setComment('Ceci est un commentaire  ');

        $result = $service->CommentaireNonAutorise( $this->comment );

        $this->assertFalse($result);
    }
}
