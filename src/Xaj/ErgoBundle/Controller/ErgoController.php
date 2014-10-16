<?php
namespace Xaj\ErgoBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Xaj\ErgoBundle\Entity\Boat;
use Xaj\ErgoBundle\Entity\Rower;
use Xaj\ErgoBundle\Entity\Leader;
use Xaj\ErgoBundle\Entity\User;

class ErgoController extends FOSRestController
{
    /**
     * @Get("/boats")
     * @View()
     */
    public function getBoatsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $boats = $em->getRepository('XajErgoBundle:Boat')->getBoatsNotDeleted();

        return $boats;
    }

    /**
     * @Get("/boats/deleted")
     * @View()
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function getDeletedBoatsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $boats = $em->getRepository('XajErgoBundle:Boat')->getDeletedBoats();

        return $boats;
    }

    /**
     * @Get("/boats/{boat}")
     * @ParamConverter("boat", class="Xaj\ErgoBundle\Entity\Boat", options={"id" = "boat"})
     * @View()
     */
    public function getBoatAction(Boat $boat)
    {
        return $boat;
    }

    /**
     * @Post("/boats/add")
     * @RequestParam(name="name")
     * @RequestParam(name="category")
     * @View()
     */
    public function addBoatAction($name, $category, $record = 0, $payment = false, $valid = false)
    {
        $em = $this->getDoctrine()->getManager();

        $boat = new Boat();
        $boat->setName($name);
        $boat->setCategory($category);
        $boat->setRecord($record);
        $boat->setPayment($payment);
        $boat->setValid($valid);

        $em->persist($boat);
        $em->flush();

        return $boat;
    }

    /**
     * @Post("/boats/valid/{boat}")
     * @ParamConverter("boat", class="Xaj\ErgoBundle\Entity\Boat", options={"id" = "boat"})
     * @View()
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function validBoatAction(Boat $boat)
    {
        $em = $this->getDoctrine()->getManager();

        $boat->setValid(true);

        $em->persist($boat);
        $em->flush();

        return $boat;
    }

    /**
     * @Post("/boats/pay/{boat}")
     * @ParamConverter("boat", class="Xaj\ErgoBundle\Entity\Boat", options={"id" = "boat"})
     * @View()
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function payBoatAction(Boat $boat)
    {
        $em = $this->getDoctrine()->getManager();

        $boat->setPayment(true);

        $em->persist($boat);
        $em->flush();

        return $boat;
    }

    /**
     * @Post("/boats/record/{boat}")
     * @ParamConverter("boat", class="Xaj\ErgoBundle\Entity\Boat", options={"id" = "boat"})
     * @RequestParam(name="temps")
     * @View()
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function recordBoatAction(Boat $boat, $temps)
    {
        $em = $this->getDoctrine()->getManager();

        $boat->setRecord($temps);

        $em->persist($boat);
        $em->flush();

        return $boat;
    }

    /**
     * @Delete("/boats/{boat}")
     * @ParamConverter("boat", class="Xaj\ErgoBundle\Entity\Boat", options={"id" = "boat"})
     * @View()
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function removeBoatAction(Boat $boat)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($boat);
        $em->flush();
    }

    /**
     * @Post("/boats/softremove/{boat}")
     * @ParamConverter("boat", class="Xaj\ErgoBundle\Entity\Boat", options={"id" = "boat"})
     * @View()
     */
    public function softremoveBoatAction(Boat $boat)
    {
        $em = $this->getDoctrine()->getManager();

        $boat->setDeleted(true);

        $em->persist($boat);
        $em->flush();

        return $boat;
    }

    /**
     * @Get("/boats/count")
     * @View()
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function countBoatsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('XajErgoBundle:Boat');
        $total = $repo->countTotal();

        return $total;
    }

    /**
     * @Get("/rowers")
     * @View()
     */
    public function getRowersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $rowers = $em->getRepository('XajErgoBundle:Rower')->findAll();

        return $rowers;
    }

    /**
     * @Get("/rowers/{rower}")
     * @ParamConverter("rower", class="Xaj\ErgoBundle\Entity\Rower", options={"id" = "rower"})
     * @View()
     */
    public function getRowerAction(Rower $rower)
    {
        return $rower;
    }

    /**
     * @Post("/rowers/add")
     * @RequestParam(name="lastname")
     * @RequestParam(name="firstname")
     * @RequestParam(name="boat")
     * @ParamConverter("boat", class="Xaj\ErgoBundle\Entity\Boat", options={"id" = "boat"})
     * @View()
     */
    public function addRowerAction($lastname, $firstname, Boat $boat)
    {
        $em = $this->getDoctrine()->getManager();

        $rower = new Rower($boat);
        $rower->setLastname($lastname);
        $rower->setFirstname($firstname);

        $em->persist($rower);
        $em->flush();

        return $rower;
    }

    /**
     * @Delete("/rowers/{rower}")
     * @ParamConverter("rower", class="Xaj\ErgoBundle\Entity\Rower", options={"id" = "rower"})
     * @View()
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function removeRowerAction(Rower $rower)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($rower);
        $em->flush();
    }

    /**
     * @Post("/leaders/add")
     * @RequestParam(name="boat")
     * @RequestParam(name="email")
     * @RequestParam(name="phone")
     * @RequestParam(name="club")
     * @RequestParam(name="rower")
     * @ParamConverter("boat", class="Xaj\ErgoBundle\Entity\Boat", options={"id" = "boat"})
     * @ParamConverter("rower", class="Xaj\ErgoBundle\Entity\Rower", options={"id" = "rower"})
     *
     * @View()
     */
    public function addLeaderAction(Rower $rower, $email, $phone, $club, Boat $boat)
    {
        $em = $this->getDoctrine()->getManager();

        $leader = new Leader($boat, $rower);
        $leader->setEmail($email);
        $leader->setPhone($phone);
        $leader->setClub($club);

        $em->persist($leader);
        $em->flush();

        return $leader;
    }

    /**
     * @Post("/boats/email/{boat}")
     * @ParamConverter("boat", class="Xaj\ErgoBundle\Entity\Boat", options={"id" = "boat"})
     * @View()
     */
    public function sendRecapMailAction(Boat $boat)
    {
        $message = \Swift_Message::newInstance()
                ->setSubject('Confirmation de votre inscription à ErgometriX 2014')
                ->setFrom('andre.gourdon@polytechnique.edu')
                ->setTo($boat->getLeader()->getEmail())
                ->setBody(
                    $this->renderView('XajErgoBundle:Boat:email.html.twig')
                    )
                ;
        $this->get('mailer')->send($message);

        return $message->getBody();
    }

    /**
     * @Get("/users")
     * @View()
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function getUsersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('XajErgoBundle:User')->findAll();

        return $users;
    }

    /**
     * @Get("/users/{user}")
     * @ParamConverter("user", class="Xaj\ErgoBundle\Entity\User", options={"id" = "user"})
     * @View()
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function getUserAction(User $user)
    {
        return $user;
    }

    /**
     * @Post("/users/add")
     * @RequestParam(name="lastname")
     * @RequestParam(name="firstname")
     * @RequestParam(name="login")
     * @RequestParam(name="password")
     * @RequestParam(name="email")
     *
     * @View()
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function addUserAction($lastname, $firstname, $login, $email, $password)
    {
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $encoder = $this->get('security.encoder_factory')->getEncoder($user);

        $user->setLastname($lastname);
        $user->setFirstname($firstname);
        $user->setLogin($login);
        $user->setEmail($email);
        $pwd = $encoder->encodePassword($password, $user->getSalt());
        $user->setPassword($pwd);

        $em->persist($user);
        $em->flush();

        $user->setPassword('');
        $user->setSalt('');

        return $user;
    }

    /**
     * @Delete("/users/{user}")
     * @ParamConverter("user", class="Xaj\ErgoBundle\Entity\User", options={"id" = "user"})
     * @View()
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function removeUserAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
    }

    /**
     * @Post("/users/{user}/changepwd")
     * @ParamConverter("user", class="Xaj\ErgoBundle\Entity\User", options={"id" = "user"})
     * @View()
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function changePwdAction(User $user, $oldpwd, $newpwd)
    {
        $em = $this->getDoctrine()->getManager();
    }
}
?>