<?php
namespace App\Service;
use App\Entity\Comment;
class VerificationComment
{
    public function CommentaireNonAutorise(Comment $comment){
$nonAutorise =[
"mauvais",
"merde",
"pourri",
"toto"
];

foreach ($nonAutorise as $word) {
   if(strpos($comment->getComment(), $word)){
       return true;
   }
}
return false;

    }


}
