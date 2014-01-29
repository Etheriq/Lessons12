<?php
/**
 * Created by PhpStorm.
 * User: Yuriy Tarnavskiy
 * Date: 27.01.14
 * Time: 21:17
 */

namespace Etheriq\BlogBundle\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Etheriq\BlogBundle\Entity\Comments;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadCommentsToBlogData  extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function getOrder()
    {
        return 6;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {

        foreach ($this->getCommentsArray() as $commentText) {

            $comment = new Comments();
//            $randomAuthorId = mt_rand(1, 2);
//            $user = $this->container
//                ->get('doctrine')
//                ->getManager()
//                ->getRepository('EtheriqAdminBlogBundle:User')
//                ->findOneById($randomAuthorId);
//            $comment->setAuthor($user);
            $randomBlogId = mt_rand(1, 17);
            $blog = $this->container
                ->get('doctrine')
                ->getManager()
                ->getRepository('EtheriqBlogBundle:Blog')
                ->findOneById($randomBlogId);
            $comment->setBlog($blog);
            $comment->setTextComment($commentText);
            $randomRating = mt_rand(-5, 5);
            $comment->setRating($randomRating);

            $manager->persist($comment);
        }

        $manager->flush();
    }

    protected function getCommentsArray()
    {
        return array(
            "Proin a dolor ornare, hendrerit risus et, gravida est.",
            "Quisque scelerisque purus vitae felis faucibus, at vehicula velit viverra.",
            "Fusce non nibh sit amet felis vulputate elementum.",
            "Phasellus at lorem ac quam blandit consequat.",
            "Aenean semper justo at tempus tristique.",
            "Maecenas pharetra erat eget nisl scelerisque, eget congue lorem laoreet.",
            "Fusce feugiat nisl vel felis suscipit dignissim.",
            "Etiam non mauris fermentum, euismod justo dictum, porta enim.",
            "Proin et justo ac libero ultricies ullamcorper.",
            "Mauris interdum mi eu enim congue, at sollicitudin neque pharetra.",
            "Pellentesque accumsan neque quis arcu accumsan dignissim.",
            "Etiam lobortis lorem eget volutpat hendrerit.",
            "Aliquam tempor purus vitae diam rutrum convallis.",
            "Aenean tempus odio sed volutpat volutpat.",
            "Suspendisse quis nisi sed odio tempor tempus ac nec justo.",
            "Proin ullamcorper risus at sem aliquam, eget auctor quam porttitor.",
            "Ut vitae urna aliquet, dignissim justo vitae, tempor odio.",
            "Nulla sodales quam vitae turpis dignissim bibendum.",
            "Curabitur sed velit eget sem fermentum viverra lacinia a turpis.",
            "Pellentesque vitae risus non risus commodo imperdiet.",
            "Aenean auctor tellus bibendum mattis euismod.",
            "Integer suscipit mi ultrices, porttitor dui id, mattis libero.",
            "Fusce suscipit lectus nec odio volutpat pulvinar.",
            "Vestibulum non ante nec quam viverra dictum.",
            "Mauris et nunc a felis lacinia aliquam.",
            "Ut placerat erat a ligula tempus facilisis.",
            "Nam sit amet dui in libero ultrices aliquam eu vel felis.",
            "Nunc pretium sem nec urna malesuada iaculis.",
            "Donec id augue id dolor dapibus lobortis mollis vitae odio.",
            "Nunc imperdiet purus vitae turpis luctus porta.",
            "Proin euismod erat eget pharetra dictum.",
            "Nulla tincidunt arcu in elementum cursus.",
            "Duis consectetur augue sed ultrices eleifend.",
            "Nulla id sapien eu arcu fermentum sodales at non velit.",
            "Cras sed sem vel lorem placerat condimentum vel eu lorem.",
            "Suspendisse consectetur neque quis lacus eleifend hendrerit.",
            "Donec id nunc eget magna gravida rhoncus.",
            "Aliquam id sapien varius, interdum tellus ut, mollis nisl.",
            "Ut sed diam porttitor, cursus odio vel, tempor metus.",
            "Sed sollicitudin turpis at orci scelerisque, quis ultrices arcu congue.",
            "Donec tincidunt turpis vel libero scelerisque vestibulum.",
            "Duis volutpat orci vitae lorem luctus ornare.",
            "Etiam sit amet sem id nulla aliquam auctor.",
            "Maecenas quis nibh quis sapien dapibus vestibulum ut sed purus.",
            "Donec malesuada nulla ac lacus interdum, sit amet fringilla felis auctor.",
            "Duis at erat posuere, eleifend nibh eu, varius nunc.",
            "Praesent at tortor ut lectus interdum tincidunt.",
            "Etiam interdum turpis sit amet pretium volutpat.",
            "Mauris sagittis justo at nunc vestibulum, in dictum nunc scelerisque.",
            "Maecenas faucibus justo quis tortor mattis, vel viverra turpis condimentum.",
            "Nullam quis turpis et odio luctus viverra a ac velit.",
            "Curabitur rhoncus sapien interdum lorem semper tristique.",
            "Vivamus fermentum purus quis risus lacinia, vitae mollis nibh sollicitudin.",
            "Quisque eu nibh pellentesque lectus ultrices tincidunt gravida eget orci.",
            "Maecenas id erat non diam auctor venenatis nec ut nunc.",
            "Pellentesque faucibus sem quis gravida fermentum.",
            "Aliquam elementum nisl at feugiat ultricies.",
            "Nam vehicula magna vel nisi consequat, ut mattis ante cursus.",
            "Etiam faucibus felis eget tristique condimentum.",
            "Maecenas blandit metus id nisl iaculis aliquet.",
            "Donec quis ipsum condimentum, dictum tellus ac, interdum nisl."
        );
    }
}