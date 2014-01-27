<?php
/**
 * Created by PhpStorm.
 * File: CommentsController.php
 * User: Yuriy Tarnavskiy
 * Date: 27.01.14
 * Time: 14:19
 */

namespace Etheriq\BlogBundle\Controller;

use Etheriq\BlogBundle\Entity\Blog;
use Etheriq\BlogBundle\Entity\Comments;
use Etheriq\BlogBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class CommentsController extends Controller
{
    public function addNewCommentAction($blog = null, Request $request)
    {
        $securityContext = $this->get('security.context');
        $user = $securityContext->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $blogShow = $em->getRepository('EtheriqBlogBundle:Blog')->findOneBySlug($blog);

        $comment = new Comments();

        $formComment = $this->createForm(new CommentType(), $comment);
        $formComment->handleRequest($request);

        if($formComment->isValid()) {
            $newComment = $this->getDoctrine()->getManager();

            $comment->setAuthor($user);
            $comment->setBlog($blogShow);

            var_dump($blog, $comment); exit;

            $newComment->persist($comment);
            $newComment->flush();

            //  *******************************************************************
            // creating the ACL
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($comment);
            $acl = $aclProvider->createAcl($objectIdentity);

            // retrieving the security identity of the currently logged-in user
            $securityIdentity = UserSecurityIdentity::fromAccount($user);

            // grant owner access
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);
            //  *******************************************************************

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('EtheriqBlogBundle:pages:comments.html.twig', array(
            'comment_form' => $formComment->createView()
        ));
    }
}