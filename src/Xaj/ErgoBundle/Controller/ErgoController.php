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

class ErgoController extends FOSRestController
{
    /**
     * @Get("/boats")
     * @View()
     *
     * 
     */
    public function getBoatsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $boats = $em->getRepository('XajErgoBundle:Boat')->findAll();

        return $boats;
    }

    /**
     * @Get("/boats/{boat}")
     * @ParamConverter("boat", class="Xaj\ErgoBundle\Entity\Boat", options={"id" = "boat"})
     * @View()
     *
     * 
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
     *
     * 
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
     *
     * 
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
     *
     * 
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
     *
     * 
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
}
?>